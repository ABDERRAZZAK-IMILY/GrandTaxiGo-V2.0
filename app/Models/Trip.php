<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Trip extends Model
{

    use HasFactory;

    protected $fillable = [
        'driver_id', 'departure_location', 'destination', 'departure_time', 'available_seats', 'status'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function driver() {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    public function ratings()
{
    return $this->hasMany(Rating::class);
}
    
}
