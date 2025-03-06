<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Trip;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRatingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class RatingController extends Controller
{ 
    public function rateDriver($trip_id)
    {
        $trip = Trip::with('driver')->findOrFail($trip_id);
        $reservation = Reservation::where('trip_id', $trip_id)
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->firstOrFail();

        $existingRating = Rating::where('trip_id', $trip_id)
            ->where('rated_by', Auth::id())
            ->where('user_id', $trip->driver->id)
            ->first();

        if ($existingRating) {
            $trip = Trip::findOrFail($trip_id);
            return redirect()->route('trip.show', $trip->id)
                ->with('error', 'لقد قمت بتقييم هذا السائق مسبقاً');
        }

        return view('ratings.rate_driver', compact('trip'));
    }

   
    public function ratePassenger($trip_id, $user_id)
    {
        $trip = Trip::findOrFail($trip_id);
        
        if ($trip->driver_id !== Auth::id()) {
            return redirect()->route('home')
                ->with('error', 'ليس لديك صلاحية تقييم هذا الراكب');
        }

        $reservation = Reservation::where('trip_id', $trip_id)
            ->where('user_id', $user_id)
            ->where('status', 'completed')
            ->firstOrFail();

        $passenger = User::findOrFail($user_id);

        $existingRating = Rating::where('trip_id', $trip_id)
            ->where('rated_by', Auth::id())
            ->where('user_id', $user_id)
            ->first();

        if ($existingRating) {
            $trip = Trip::findOrFail($trip_id);
            return redirect()->route('trip.show', $trip->id)
                ->with('error', 'لقد قمت بتقييم هذا الراكب مسبقاً');
        }

        return view('ratings.rate_passenger', compact('trip', 'passenger'));
    }

  
    public function store(StoreRatingRequest $request)
    {
        $validated = $request->validated();

        $existingRating = Rating::where('trip_id', $validated['trip_id'])
            ->where('rated_by', Auth::id())
            ->where('user_id', $validated['user_id'])
            ->first();

        if ($existingRating) {
            return back()->with('error', '');
        }

        $rating = Rating::create([
            'user_id' => $validated['user_id'],
            'rated_by' => Auth::id(),
            'trip_id' => $validated['trip_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        $this->updateUserAverageRating($validated['user_id']);

        $trip = Trip::findOrFail($validated['trip_id']);
        return redirect()->route('trip.show', $trip->id)
            ->with('success', 'save rate');
    }

  
    public function update(StoreRatingRequest $request, $id)
    {
        $rating = Rating::findOrFail($id);

        if ($rating->rated_by !== Auth::id()) {
            return back()->with('error', 'you are not have accece');
        }

        $validated = $request->validated();
        
        $rating->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        $this->updateUserAverageRating($rating->user_id);

        $trip = Trip::findOrFail($rating->trip_id);
        return redirect()->route('trip.show', $trip->id)
            ->with('success', 'updete Rating');
    }

   
    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);

        if ($rating->rated_by !== Auth::id()) {
            return back()->with('error', 'you are not admin');
        }

        $trip_id = $rating->trip_id;
        $user_id = $rating->user_id;
        
        $rating->delete();

        $this->updateUserAverageRating($user_id);

        $trip = Trip::findOrFail($trip_id);
        return redirect()->route('trip.show', $trip->id)
            ->with('success', 'delete suuue');
    }

 
    public function userRatings($user_id)
    {
        $user = User::findOrFail($user_id);
        
        $ratings = Rating::where('user_id', $user_id)
            ->with(['ratedBy', 'trip'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $averageRating = Rating::where('user_id', $user_id)->avg('rating') ?? 0;
            
        return view('ratings.user_ratings', compact('user', 'ratings', 'averageRating'));
    }

  
    private function updateUserAverageRating($user_id)
    {
        $user = User::findOrFail($user_id);
        $averageRating = Rating::where('user_id', $user_id)->avg('rating');
        
        if (Schema::hasColumn('users', 'average_rating')) {
            $user->average_rating = $averageRating ?: 0;
            $user->save();
        }
        
        
    }
}