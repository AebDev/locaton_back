<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    //
    protected $fillable = [
        'nom_categorie','age_min','annee_permis_min',
    ];

    public function vehicules()
    {
        return $this->hasMany(Vehicule::class);
    }
}
