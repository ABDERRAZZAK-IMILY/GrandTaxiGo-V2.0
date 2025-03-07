@extends('layouts.app')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">لوحة تحكم المسؤول</h1>
        
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        <div class="bg-white rounded-lg shadow-md overflow-hidden border-r-4 border-blue-500">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-blue-500 uppercase mb-1">إجمالي المستخدمين</div>
                        <div class="text-xl font-bold text-gray-800">{{ $stats['users']['total'] }}</div>
                        <div class="text-sm text-gray-500">
                            <span class="text-green-500">+{{ $stats['users']['new_today'] }}</span> اليوم
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-users text-2xl text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden border-r-4 border-green-500">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-green-500 uppercase mb-1">الرحلات المكتملة</div>
                        <div class="text-xl font-bold text-gray-800">{{ $stats['trips']['completed'] }}</div>
                        <div class="text-sm text-gray-500">
                            من أصل <span class="font-medium">{{ $stats['trips']['total'] }}</span> رحلة
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-check-circle text-2xl text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden border-r-4 border-cyan-500">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-cyan-500 uppercase mb-1">الإيرادات التقديرية</div>
                        <div class="text-xl font-bold text-gray-800">{{ $stats['revenue']['estimated'] }} درهم</div>
                        <div class="text-sm text-gray-500">
                            من <span class="font-medium">{{ $stats['reservations']['accepted'] }}</span> حجز مؤكد
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-dollar-sign text-2xl text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden border-r-4 border-yellow-500">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-yellow-500 uppercase mb-1">السائقين</div>
                        <div class="text-xl font-bold text-gray-800">{{ $stats['users']['drivers'] }}</div>
                        <div class="text-sm text-gray-500">
                            <span class="font-medium">{{ $stats['trips']['active'] }}</span> رحلة نشطة
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-taxi text-2xl text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
        <div class="lg:col-span-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4">
                <div class="px-4 py-3 flex items-center justify-between border-b">
                    <h6 class="text-lg font-bold text-blue-500">الحجوزات الأخيرة</h6>
                    <a href="{{ route('admin.reservations') }}" class="text-blue-500 hover:text-blue-700">
                        عرض الكل <i class="fas fa-arrow-left ml-1"></i>
                    </a>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right">المعرف</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right">الراكب</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right">الوجهة</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right">الحالة</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right">التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $latestReservations = \App\Models\Reservation::with(['user', 'trip'])
                                        ->latest()
                                        ->take(5)
                                        ->get();
                                @endphp
                                
                                @forelse($latestReservations as $reservation)
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200">#{{ $reservation->id }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $reservation->user->name }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $reservation->trip->destination }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        @if($reservation->status == 'pending')
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">قيد الانتظار</span>
                                        @elseif($reservation->status == 'accepted')
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">مقبول</span>
                                        @elseif($reservation->status == 'cancelled')
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">ملغي</span>
                                        @elseif($reservation->status == 'completed')
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">مكتمل</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $reservation->created_at->format('Y-m-d') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-500">لا توجد حجوزات حتى الآن</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-4 py-3 border-b">
                    <h6 class="text-lg font-bold text-blue-500">الرحلات حسب المدينة</h6>
                </div>
                <div class="p-4">
                    <div class="h-64">
                        <canvas id="tripsByCityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4">
                <div class="px-4 py-3 border-b">
                    <h6 class="text-lg font-bold text-blue-500">توزيع التقييمات</h6>
                </div>
                <div class="p-4">
                    <div class="pt-4 h-64">
                        <canvas id="ratingsDistributionChart"></canvas>
                    </div>
                    <div class="mt-4 text-center">
                        <div class="text-sm text-gray-500">متوسط التقييم</div>
                        <div class="text-xl font-bold text-blue-500">
                            {{ number_format($stats['ratings']['average'] ?? 0, 1) }} / 5
                        </div>
                        <div class="text-sm text-gray-500">
                            من أصل {{ $stats['ratings']['total'] }} تقييم
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        var tripsByCityCtx = document.getElementById("tripsByCityChart").getContext('2d');
        var tripsByCityData = @json($stats['trips']['by_city'] ?? []);
        
        new Chart(tripsByCityCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(tripsByCityData),
                datasets: [{
                    label: 'عدد الرحلات',
                    data: Object.values(tripsByCityData),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        
        var ratingsCtx = document.getElementById("ratingsDistributionChart").getContext('2d');
        
        var ratingsData = [0, 0, 0, 0, 0];
        
        @php
            $ratingDistribution = \App\Models\Rating::select('rating', DB::raw('COUNT(*) as count'))
                ->groupBy('rating')
                ->orderBy('rating')
                ->get()
                ->pluck('count', 'rating')
                ->toArray();
            
            $ratingsDataArray = [
                $ratingDistribution[1] ?? 0,
                $ratingDistribution[2] ?? 0,
                $ratingDistribution[3] ?? 0,
                $ratingDistribution[4] ?? 0,
                $ratingDistribution[5] ?? 0
            ];
        @endphp
        
        var ratingsData = @json($ratingsDataArray);
        
        new Chart(ratingsCtx, {
            type: 'doughnut',
            data: {
                labels: ["1 نجمة", "2 نجمة", "3 نجوم", "4 نجوم", "5 نجوم"],
                datasets: [{
                    data: ratingsData,
                    backgroundColor: [
                        '#ef4444', 
                        '#f97316', 
                        '#f59e0b', 
                        '#10b981', 
                        '#059669'  
                    ],
                    hoverBackgroundColor: [
                        '#dc2626',
                        '#ea580c',
                        '#d97706',
                        '#059669',
                        '#047857'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
      
        new Chart(reservationsByDayCtx, {
            type: 'line',
            data: {
                labels: sortedDays,
                datasets: [{
                    label: 'عدد الحجوزات',
                    data: sortedCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>

@endsection