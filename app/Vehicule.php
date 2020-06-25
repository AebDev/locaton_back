<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    protected $fillable = [
        'matricule','marque','modele','couleur','puissance',
        'cout_par_jour','nb_places','nb_portes','climatisation',
        'boite_vitesse','franchise','category_id'
    ];

    public function categories()
    {
        return $this->belongsTo(Categorie::class);
    }
}
