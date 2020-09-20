<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    protected $fillable = [
        'matricule','marque','modele','image','couleur','carburant',
        'cout_par_jour','nb_places','nb_portes','climatisation',
        'boite_vitesse','franchise','categorie_id'
    ];

    public function categories()
    {
        return $this->belongsTo('App\Categorie','categorie_id');
    }

    public function locations()
    {
        return $this->hasMany('App\Location','vehicule_id');
    }
}
