<?php

namespace  App\Services;

use App\Contract\TacheRepositoryInterface;
use App\Models\Tache;
use Illuminate\Support\Facades\Auth;

class TacheRepository implements TacheRepositoryInterface{

    public function liste()
    {
        return Tache::orderBy('id', 'desc')->get();
    }


    public function store(array $data)
    {

        $tache = new Tache();
        $tache->title = $data['titre'];
        $tache->description = $data['description'];
        $tache->date_echeance = $data['date_echeance'];
        $tache->date_creation = $data['date_creation'];
        $tache->enregistrer_par = Auth::user()->id;
        $tache->statut = 1;
        $tache->save();

        return $tache;
    }

    public function update(array $data, $id){

        $tache = Tache::find($data['id']);
        $tache->title = $data['titre'];
        $tache->description = $data['description'];
        $tache->date_echeance = $data['date_echeance'];
        $tache->date_creation = $data['date_creation'];
        $tache->enregistrer_par = Auth::user()->id;
        $tache->statut = $data['statut'];
        $tache->modifier_par = Auth::user()->id;
        $tache->update();

        return $tache;
    }

    public function edit ($id){}

}
