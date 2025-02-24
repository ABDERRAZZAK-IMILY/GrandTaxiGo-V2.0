<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    //

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function trip() {
        return $this->belongsTo(Trip::class);
    }
    


    public function driver() {
        return $this->belongsTo(User::class, 'driver_id');
    }
    public function reservations() {
        return $this->hasMany(Reservation::class);
    }
    
}
