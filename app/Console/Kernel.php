<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * These schedules are run in a default environment.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        // تحديث توفر السائقين تلقائيًا كل ساعة
        $schedule->call(function () {
            // تحديث حالة الرحلات المكتملة
            $completedTrips = Trip::where('departure_time', '<', Carbon::now())
                ->where('status', '!=', 'completed')
                ->get();
                
            foreach ($completedTrips as $trip) {
                $trip->status = 'completed';
                $trip->save();
                
                // تحديث حالة الحجوزات المرتبطة بالرحلة
                foreach ($trip->reservations as $reservation) {
                    if ($reservation->status === 'accepted') {
                        $reservation->status = 'completed';
                        $reservation->save();
                    }
                }
            }
            
            // تحديث توفر السائقين بناءً على الرحلات الحالية
            $drivers = User::where('role', 'driver')->get();
            
            foreach ($drivers as $driver) {
                // التحقق من وجود رحلات نشطة للسائق
                $activeTrips = Trip::where('driver_id', $driver->id)
                    ->where('departure_time', '>', Carbon::now())
                    ->where('departure_time', '<', Carbon::now()->addHours(2))
                    ->count();
                
                // تحديث حالة توفر السائق
                $driver->is_available = ($activeTrips === 0);
                $driver->save();
            }
        })->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
} 