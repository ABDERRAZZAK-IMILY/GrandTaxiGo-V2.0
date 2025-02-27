<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trip extends Model
{

    use HasFactory;

    protected $fillable = [
        'driver_id', 'departure_location', 'destination', 'departure_time', 'available_seats'
    ];
    public function driver() {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }
    
}
