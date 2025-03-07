<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Mail\ReservationConfirmed;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Events\Notification_platform;

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

        // $driver = User::where('role', 'driver')->get();

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
        return view('reservation.show' , compact('reservation'));

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

            $reservationData = json_encode([
                'id' => $reservation->id,
                'passenger' => $reservation->user->name,
                'from' => $reservation->trip->departure_location,
                'to' => $reservation->trip->destination,
                'date' => $reservation->trip->departure_time,
            ]);

            $qrCode = QrCode::format('png')
            ->size(200)
            ->generate($reservationData);

            $qrCodePath = 'qrcodes/reservation-' . $reservation->id . '.png';
            Storage::disk('public')->put($qrCodePath, $qrCode);

           Mail::to($reservation->user->email)->send(new ReservationConfirmed($reservation, $qrCodePath));


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


  
  public function myReservations() {
    $reservations = Cache::remember('user_reservations_' . Auth::id(), 60 * 5, function () {
        return Reservation::where('user_id', Auth::id())
            ->with('trip')
            ->orderBy('created_at', 'desc')
            ->get();
    });

    return view('reservation.my_reservations', compact('reservations'));
}
  


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
