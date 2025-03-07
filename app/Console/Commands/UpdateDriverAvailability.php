<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Trip;
use Carbon\Carbon;

class UpdateDriverAvailability extends Command
{
    protected $signature = 'drivers:update-availability';
    protected $description = 'تحديث توافر السائقين';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $drivers = User::all();

        foreach ($drivers as $driver) {
            $currentTrip = Trip::where('driver_id', $driver->id)
                                ->where('start_time', '<=', Carbon::now())
                                ->where('end_time', '>=', Carbon::now())
                                ->first();

            $upcomingTrip = Trip::where('driver_id', $driver->id)
                                ->where('start_time', '>', Carbon::now())
                                ->orderBy('start_time', 'asc')
                                ->first();

            if ($currentTrip) {
                $driver->availability = false;
            } elseif ($upcomingTrip) {
                $driver->availability = true;
            } else {
                $driver->availability = true;
            }

            $driver->save();
        }

        $this->info('نجاح');
    }
}
