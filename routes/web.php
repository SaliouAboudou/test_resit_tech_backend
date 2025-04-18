<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\TacheController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('wecome');
});





Route::middleware('auth:api')->get('/user', [AuthController::class, 'me']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);


// Prefixe group route  Tache ->middleware(['auth:api'])
Route::prefix('tache')->group(function(){
    Route::get('/liste', [TacheController::class, 'liste']); // route recuperation
    Route::post('/update', [TacheController::class, 'update']); // route mise a jour
    Route::post('/store', [TacheController::class, 'store']); // route creation
});
