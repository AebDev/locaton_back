<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'montant','etat','num_de_vol','compagnie_aerienne','date_debut',
        'date_debut','date_fin','type_de_protection','option_gps',
        'option_wifi','option_Rehausseur_enfant','option_Rehausseur_bebe',
        'user_id','vehicule_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicules()
    {
        return $this->belongsTo('App\Vehicule','vehicule_id','id');
    }

    public function penalites()
    {
        return $this->hasMany(Penalite::class);
    }
}
