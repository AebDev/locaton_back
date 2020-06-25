<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'montant','etat','num_de_vol','compagnie_aerienne','date_debut',
        'date_debut','date_fin','type_de_protection','option_gps',
        'option_wifi','option_Rehausseur_enfant','option_Rehausseur_bebe',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicules()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function penalites()
    {
        return $this->hasMany(Penalite::class);
    }
}
