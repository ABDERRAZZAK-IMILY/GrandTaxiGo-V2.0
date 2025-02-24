<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Trip;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */


 

public function run()
{
    $driver = User::factory()->create();

    Trip::create([
        'driver_id' => $driver->id,
        'departure_location' => 'Rabat',
        'destination' => 'Tanger',
        'departure_time' => now()->addDays(3),
        'available_seats' => 3
    ]);
}

}
