<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function index()
    {
        $stats = Cache::remember('admin_dashboard_stats', 60 * 60, function () {
            $totalUsers = User::count();
            $totalDrivers = User::where('role', 'driver')->count();
            $totalPassengers = User::where('role', 'passenger')->count();
            $newUsersToday = User::whereDate('created_at', Carbon::today())->count();
            
            $totalTrips = Trip::count();
            $activeTrips = Trip::where('departure_time', '>', now())->count();
            $completedTrips = Trip::where('departure_time', '<', now())->count();
            
            $totalReservations = Reservation::count();
            $pendingReservations = Reservation::where('status', 'pending')->count();
            $acceptedReservations = Reservation::where('status', 'accepted')->count();
            $cancelledReservations = Reservation::where('status', 'cancelled')->count();
            
            $totalRatings = Rating::count();
            $avgRating = Rating::avg('rating');
            
            $estimatedRevenue = Reservation::where('status', 'accepted')->count() * 50;
            
            $activityByHour = Reservation::select(DB::raw('EXTRACT(HOUR FROM created_at) as hour'), DB::raw('COUNT(*) as count'))
                ->groupBy('hour')
                ->orderBy('hour')
                ->get()
                ->pluck('count', 'hour')
                ->toArray();
            
            $hourlyActivity = [];
            for ($i = 0; $i < 24; $i++) {
                $hourlyActivity[$i] = $activityByHour[$i] ?? 0;
            }
            
            $tripsByCity = Trip::select('departure_location', DB::raw('COUNT(*) as count'))
                ->groupBy('departure_location')
                ->orderByDesc('count')
                ->limit(5)
                ->get()
                ->pluck('count', 'departure_location')
                ->toArray();
           
            $daysOfWeek = [
                0 => 'الأحد',
                1 => 'الإثنين',
                2 => 'الثلاثاء',
                3 => 'الأربعاء',
                4 => 'الخميس',
                5 => 'الجمعة',
                6 => 'السبت'
            ];
            
            $reservationsByDay = DB::table('reservations')
                ->select(DB::raw('EXTRACT(DOW FROM created_at) as dow'), DB::raw('COUNT(*) as count'))
                ->groupBy('dow')
                ->orderBy('dow')
                ->get();
            
            $reservationsByDayFinal = [];
            foreach ($daysOfWeek as $dow => $dayName) {
                $count = 0;
                foreach ($reservationsByDay as $item) {
                    if ((int)$item->dow === $dow) {
                        $count = $item->count;
                        break;
                    }
                }
                $reservationsByDayFinal[$dayName] = $count;
            }
            
            return [
                'users' => [
                    'total' => $totalUsers,
                    'drivers' => $totalDrivers,
                    'passengers' => $totalPassengers,
                    'new_today' => $newUsersToday
                ],
                'trips' => [
                    'total' => $totalTrips,
                    'active' => $activeTrips,
                    'completed' => $completedTrips,
                    'by_city' => $tripsByCity
                ],
                'reservations' => [
                    'total' => $totalReservations,
                    'pending' => $pendingReservations,
                    'accepted' => $acceptedReservations,
                    'cancelled' => $cancelledReservations,
                    'by_day' => $reservationsByDayFinal
                ],
                'ratings' => [
                    'total' => $totalRatings,
                    'average' => $avgRating
                ],
                'revenue' => [
                    'estimated' => $estimatedRevenue
                ],
                'activity' => [
                    'by_hour' => $hourlyActivity
                ]
            ];
        });
        
        return view('admin.dashboard', compact('stats'));
    }

    public function users() 
    {
        $users = Cache::remember('admin_users_list', 60 * 15, function () {
            return User::withTrashed()
                ->withCount(['trips', 'reservations', 'ratings'])
                ->paginate(10);
        });
        
        return view('admin.users', compact('users'));
    }

    public function user($id)
    {
        $user = User::findOrFail($id);
        
        $userData = Cache::remember('admin_user_data_' . $id, 60 * 15, function () use ($id, $user) {
            $ratings = Rating::where('user_id', $id)
                ->orWhere('rated_by', $id)
                ->with(['user', 'ratedBy'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            $trips = [];
            if ($user->role === 'driver') {
                $trips = Trip::where('driver_id', $id)
                    ->with(['reservations', 'reservations.user'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            } else {
                $trips = Reservation::where('user_id', $id)
                    ->with(['trip', 'trip.driver'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }
            
            return [
                'ratings' => $ratings,
                'trips' => $trips
            ];
        });
        
        return view('admin.show', [
            'user' => $user,
            'ratings' => $userData['ratings'],
            'trips' => $userData['trips']
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        Cache::forget('admin_users_list');
        Cache::forget('admin_user_' . $id);
        Cache::forget('admin_dashboard_stats');
        
        return redirect()->route('admin.users')->with('success', 'تم حذف المستخدم بنجاح');
    }
    
    
    public function trips(Request $request)
    {
        $dateRange = $request->get('date_range', 'all');
        
        $cacheKey = 'admin_trips_' . $dateRange;
        
        $trips = Cache::remember($cacheKey, 60 * 15, function () use ($dateRange) {
            $query = Trip::query()->with(['driver', 'reservations', 'reservations.user']);
            
            if ($dateRange !== 'all') {
                switch ($dateRange) {
                    case 'today':
                        $query->whereDate('created_at', Carbon::today());
                        break;
                    case 'week':
                        $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                        break;
                    case 'month':
                        $query->whereMonth('created_at', Carbon::now()->month)
                              ->whereYear('created_at', Carbon::now()->year);
                        break;
                }
            }
            
            return $query->orderBy('created_at', 'desc')->paginate(15);
        });
        
        return view('admin.trips', compact('trips', 'dateRange'));
    }
    
    public function tripDetails($id)
    {
        $trip = Cache::remember('admin_trip_' . $id, 60 * 15, function () use ($id) {
            return Trip::with(['driver', 'reservations', 'reservations.user', 'ratings'])
                ->findOrFail($id);
        });
            
        return view('admin.trips.show', compact('trip'));
    }
    
    public function ratings()
    {
        $ratingsData = Cache::remember('admin_ratings_stats', 60 * 30, function () {
            $ratings = Rating::with(['user', 'ratedBy'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
                
            $avg_rating = Rating::avg('rating');
            $total_ratings = Rating::count();
            
            $rating_distribution = Rating::select('rating', DB::raw('COUNT(*) as count'))
                ->groupBy('rating')
                ->orderBy('rating')
                ->get();
                
            return [
                'ratings' => $ratings,
                'avg_rating' => $avg_rating,
                'total_ratings' => $total_ratings,
                'rating_distribution' => $rating_distribution
            ];
        });
            
        return view('admin.ratings.index', [
            'ratings' => $ratingsData['ratings'],
            'avg_rating' => $ratingsData['avg_rating'],
            'total_ratings' => $ratingsData['total_ratings'],
            'rating_distribution' => $ratingsData['rating_distribution']
        ]);
    }
    
    public function reservations(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $cacheKey = 'admin_reservations_' . $status;
        
        $reservations = Cache::remember($cacheKey, 60 * 15, function () use ($status) {
            $query = Reservation::with(['user', 'trip', 'trip.driver']);
            
            if ($status !== 'all') {
                $query->where('status', $status);
            }
            
            return $query->orderBy('created_at', 'desc')->paginate(15);
        });
        
        return view('admin.reservations', compact('reservations', 'status'));
    }
}