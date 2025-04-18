<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Utilisateur créé avec succès']);
    }

    public function login(Request $request)
    {
        try {
            // Validation des données entrantes
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Tentative de connexion
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['message' => 'Identifiants incorrects'], 401);
            }

            // Générer un token JWT
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);

            // Retourner la réponse avec le token
            return response()->json([
                'message' => 'Connexion réussie',
                'token' => $token,
                'user' => $user,
                'status' => 201
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error lors de l \'authentification '], 500);
        }
    }

    public function me(Request $request)
    {
        try {
            return response()->json($request->user());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error lors de la recuperation des données'], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken()); // Invalider le token
            return response()->json(['message' => 'Déconnexion réussie'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Échec de la déconnexion'], 500);
        }
    }

}
