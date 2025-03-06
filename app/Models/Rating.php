<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 
        'rated_by',
        'trip_id',  
        'rating',  
        'comment',  
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ratedBy()
    {
        return $this->belongsTo(User::class, 'rated_by');
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}