<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penalite extends Model
{
    //
    protected $fillable = [
        'date_retour','cout','raison','location_id'
    ];

    public function locations()
    {
        return $this->belongsTo(Location::class);
    }
}
