<?php

namespace App\Http\Controllers;

use App\Contract\TacheRepositoryInterface;
use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{

    protected $tacheRepository;

    public function __construct( TacheRepositoryInterface $tacheRepository)
    {
        $this->tacheRepository = $tacheRepository;
    }

    public function liste(){ // cette metthode recuperer la liste des tache en fonction du user & de l agence

        $taches = $this->tacheRepository->liste();

        return response()->json([
            'taches' => $taches, // Données de la page actuelle
        ]);

    }


    public function store(Request $request){ // cette methode permet de faire l enregistrement d un tache
        // Récuperation
        $validatedData = $request->validated();  // Récupère les données validées

        $this->tacheRepository->store($validatedData); // Ajouter le tache

        return  response()->json(['message'=> 'l\'enregistrement s\'est effectué avec succès! ', 'statut' => 200]); // return le staut 200 si tout s'est bien passé
    }

    public function edit(){ // cette methode permùet de recuperer le detail d un maagasin et l affiche

    }

    public function change_status(){ // cette methode permet de changer le statut du tache soit actif => true ou inactif => false

    }

    public function update(Request $request, $id){ // cette methode permettera de faire la mise a jour d un tache

        $validatedData  = $request->validated();

        // return response()->json(['data' =>   $validatedData]);

        $tache_exist = Tache::find($id);

        if($tache_exist){
           $data = $this->tacheRepository->update($validatedData, $id);
        }else{
            return response()->json(['message'=> 'Désolé, la madification n\'a pas été effectuée!', 404]);
        }

        if($data){
            return response()->json(200);
        }

    }
}
