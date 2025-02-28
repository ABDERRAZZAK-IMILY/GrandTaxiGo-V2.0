<?php

namespace App\Http\Controllers;

use Carbon\Carbon;


use Illuminate\Http\Request;

use App\Models\Reservation;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips =   Trip::all();
        return view('reservation.index' , compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $seats = $request['available_seats'];

    $data = $request->validate([
        'trip_id' => 'required|integer'
    ]);

    $data['user_id'] = Auth::id();

    if ($seats > 0) {
        if (Reservation::create($data)) {
            $seats--;

            $trip = Trip::find($data['trip_id']);
            if ($trip) {
                $trip->available_seats = $seats;
                $trip->save();
            }

            return redirect()->back()->with('success', 'Reservation created successfully');
        }
    }

    return redirect()->back()->with('error', 'No available seats left');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservation = Reservation::find($id);

        return view('reservation.index' , compact('reservation'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


     public function acceptReservation(Request $request)
     {
         $validated = $request->validate([
             'reservation_id' => 'required|integer',
             'status' => 'required|string',
         ]);
     
         $reservation = Reservation::find($validated['reservation_id']);
     
         if ($reservation) {
             $reservation->status = "accepted";
             $reservation->save();
             return redirect()->back()->with('success', 'Reservation accepted successfully');
         } else {
             return redirect()->back()->with('error', 'Reservation not found');
         }
     }
     public function rejectReservation(Request $request)
     {
         $validated = $request->validate([
             'reservation_id' => 'required|integer',
         ]);
     
         $reservation = Reservation::find($validated['reservation_id']);
     
         if (!$reservation) {
             return back()->with('error', 'Reservation not found.');
         }
     
         if ($reservation->status === "cancelled") {
             return back()->with('error', 'This reservation has already been rejected.');
         }
     
         if (Carbon::now()->diffInHours($reservation->departure_time) < 1) {
             return back()->with('error', "You can't cancel a booking less than 1 hour before departure.");
         }
     
         $reservation->status = "cancelled";
         $reservation->save();
     
         return back()->with('success', 'Reservation successfully canceled.');
     }


     public function cancel(Request $request)
     {


         $validated = $request->validate([
             'reservation_id' => 'required|integer',
         ]);
     
         $reservation = Reservation::find($validated['reservation_id']);
     
         $trip = Trip::find($reservation->trip_id);

         if (!$reservation) {
             return back()->with('error', 'Reservation not found.');
         }
     
         if ($reservation->status === "cancelled") {
             return back()->with('error', 'This reservation has already been cancelled.');
         }
     
         if ($trip->departure_time) {
             $departure_time = Carbon::createFromTimestamp($trip->departure_time);
     
             if (Carbon::now()->diffInHours($departure_time) < 1) {
                 return back()->with('error', "You can't cancel a booking less than 1 hour before departure.");
             }
         } else {
             return back()->with('error', 'Invalid departure time.');
         }
     
         $reservation->status = "cancelled";
         $reservation->save();
     
         return back()->with('success', 'Reservation successfully cancelled.');
     }

     
  public function search($id){

    $reservation = Reservation::find($id);

    $trip = Trip::find($reservation->trip_id);

    return view("reservation.show" , compact('reservation' , 'trip'));
  }

  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
