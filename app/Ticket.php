<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'sujet','messagrie','user_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
