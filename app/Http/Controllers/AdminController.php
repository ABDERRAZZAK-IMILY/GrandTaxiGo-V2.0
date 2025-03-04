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
        return view('admin.dashboard');
    }

    public function users() 
    {
        $users = User::withTrashed()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function user($id)
    {
        $user = User::findOrFail($id);
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
        
        return view('admin.show', compact('user', 'ratings', 'trips'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé avec succès');
    }

    public function dashboard() 
    {
        $stats = Cache::remember('admin_dashboard_stats', now()->addMinutes(15), function () {
            return [
                'total_trips' => Trip::count(),
                'completed_trips' => Trip::where('status', 'completed')->count(),
                'canceled_trips' => Trip::where('status', 'canceled')->count(),
                'revenue' => Trip::where('status', 'completed')->sum('price'),
                'total_users' => User::count(),
                'total_drivers' => User::where('role', 'driver')->count(),
                'total_passengers' => User::where('role', 'passenger')->count(),
                'pending_reservations' => Reservation::where('status', 'pending')->count()
            ];
        });
    
        $latest_reservations = Reservation::with(['user', 'trip', 'trip.driver'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $monthly_stats = Cache::remember('monthly_trip_stats', now()->addHours(24), function () {
            return Trip::select(
                DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed'),
                DB::raw('SUM(CASE WHEN status = "canceled" THEN 1 ELSE 0 END) as canceled'),
                DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed'),
                DB::raw('SUM(CASE WHEN status = "canceled" THEN 1 ELSE 0 END) as canceled'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN price ELSE 0 END) as revenue')
            )
            ->whereRaw('created_at >= NOW() - INTERVAL \'6 months\'')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        });
        
        $available_drivers = User::where('role', 'driver')
            ->whereHas('driverProfile', function($query) {
                $query->where('is_available', true);
            })
            ->count();
            
        $stats['available_drivers'] = $available_drivers;
    
        return view('admin.dashboard', compact('stats', 'latest_reservations', 'monthly_stats'));
    }
    
    public function trips(Request $request)
    {
        $status = $request->get('status', 'all');
        $dateRange = $request->get('date_range', 'all');
        
        $query = Trip::query()->with(['driver', 'reservations', 'reservations.user']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
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
        
        $trips = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.trips.index', compact('trips', 'status', 'dateRange'));
    }
    
    public function tripDetails($id)
    {
        $trip = Trip::with(['driver', 'reservations', 'reservations.user', 'ratings'])
            ->findOrFail($id);
            
        return view('admin.trips.show', compact('trip'));
    }
    
    public function ratings()
    {
        $ratings = Rating::with(['user', 'ratedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        $avg_rating = Rating::avg('rating');
        $total_ratings = Rating::count();
        
        $rating_distribution = Rating::select('rating', DB::raw('COUNT(*) as count'))
            ->groupBy('rating')
            ->orderBy('rating')
            ->get();
            
        return view('admin.ratings.index', compact('ratings', 'avg_rating', 'total_ratings', 'rating_distribution'));
    }
    
 
    
    public function reservations(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Reservation::with(['user', 'trip', 'trip.driver']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $reservations = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.reservations.index', compact('reservations', 'status'));
    }
      
   
}