@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-yellow-500 text-white px-6 py-4">
                <h2 class="text-xl font-bold">الملف الشخصي</h2>
            </div>
            
            <div class="p-6">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 mb-6 md:mb-0 md:ml-6">
                        <div class="bg-gray-100 rounded-lg p-6 text-center">
                            <div class="w-24 h-24 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500 mx-auto mb-4">
                                <i class="fas fa-user text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2">{{ $user->name }}</h3>
                            
                            @if($user->role === 'driver')
                                <div class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full inline-block mb-2">
                                    <i class="fas fa-car ml-1"></i> سائق
                                </div>
                            @elseif($user->role === 'passenger')
                                <div class="bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full inline-block mb-2">
                                    <i class="fas fa-user ml-1"></i> راكب
                                </div>
                            @elseif($user->role === 'admin')
                                <div class="bg-purple-100 text-purple-800 text-sm font-semibold px-3 py-1 rounded-full inline-block mb-2">
                                    <i class="fas fa-user-shield ml-1"></i> مسؤول
                                </div>
                            @endif
                            
                            <p class="text-gray-500 mb-4">{{ $user->email }}</p>
                            
                            <div class="mb-4">
                                <div class="text-lg font-medium mb-1">متوسط التقييم</div>
                                <div class="flex justify-center mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= ($user->average_rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }} mx-0.5"></i>
                                    @endfor
                                </div>
                                <div class="text-gray-500">{{ number_format($user->average_rating ?? 0, 1) }}/5</div>
                            </div>
                            
                            <div class="text-gray-500 text-sm">
                                <i class="fas fa-calendar-alt ml-1"></i> انضم {{ $user->created_at->format('Y/m/d') }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:w-2/3">
                        @if($user->role === 'driver')
                            <div class="mb-6">
                                <h3 class="text-lg font-bold mb-3 flex items-center">
                                    <i class="fas fa-car ml-2 text-yellow-500"></i> معلومات السائق
                                </h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-gray-600">رقم الهاتف:</p>
                                            <p class="font-medium">{{ $user->phone ?? 'غير متوفر' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">نوع السيارة:</p>
                                            <p class="font-medium">{{ $user->car_model ?? 'غير متوفر' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">رقم لوحة السيارة:</p>
                                            <p class="font-medium">{{ $user->license_plate ?? 'غير متوفر' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">سنة الخبرة:</p>
                                            <p class="font-medium">{{ $user->years_experience ?? 'غير متوفر' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-lg font-bold flex items-center">
                                    <i class="fas fa-star ml-2 text-yellow-500"></i> التقييمات
                                </h3>
                                <a href="{{ route('ratings.user', $user->id) }}" class="text-yellow-500 hover:text-yellow-700 text-sm">
                                    عرض الكل <i class="fas fa-arrow-left mr-1"></i>
                                </a>
                            </div>
                            
                            @if($latestRatings->count() > 0)
                                <div class="space-y-4">
                                    @foreach($latestRatings as $rating)
                                        <div class="border border-gray-200 rounded-lg p-3 hover:shadow-sm transition">
                                            <div class="flex justify-between">
                                                <div>
                                                    <div class="flex items-center">
                                                        <span class="font-medium">{{ $rating->ratedBy->name }}</span>
                                                        @if($rating->ratedBy->role === 'driver')
                                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded-full mr-2">
                                                                سائق
                                                            </span>
                                                        @elseif($rating->ratedBy->role === 'passenger')
                                                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-0.5 rounded-full mr-2">
                                                                راكب
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="flex my-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }} ml-1"></i>
                                                        @endfor
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $rating->created_at->format('Y/m/d') }}
                                                    </div>
                                                    @if($rating->comment)
                                                        <p class="mt-1 text-gray-700 text-sm">{{ $rating->comment }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-gray-50 rounded-lg p-4 text-center text-gray-500">
                                    لا توجد تقييمات حتى الآن
                                </div>
                            @endif
                        </div>
                        
                        @if($user->role === 'driver')
                            <div>
                                <h3 class="text-lg font-bold mb-3 flex items-center">
                                    <i class="fas fa-route ml-2 text-yellow-500"></i> الرحلات المتاحة
                                </h3>
                                
                                @php
                                    $availableTrips = \App\Models\Trip::where('driver_id', $user->id)
                                        ->where('status', 'active')
                                        ->where('date', '>=', now())
                                        ->orderBy('date')
                                        ->take(3)
                                        ->get();
                                @endphp
                                
                                @if($availableTrips->count() > 0)
                                    <div class="space-y-3">
                                        @foreach($availableTrips as $trip)
                                            <a href="{{ route('trip.show', $trip->id) }}" class="block border border-gray-200 rounded-lg p-3 hover:shadow-md transition">
                                                <div class="flex justify-between items-center">
                                                    <div>
                                                        <div class="font-medium">{{ $trip->from }} إلى {{ $trip->to }}</div>
                                                        <div class="text-sm text-gray-500">
                                                            <i class="fas fa-calendar ml-1"></i> {{ $trip->date->format('Y/m/d') }}
                                                            <span class="mx-2">|</span>
                                                            <i class="fas fa-clock ml-1"></i> {{ $trip->time }}
                                                        </div>
                                                    </div>
                                                    <div class="text-yellow-500">
                                                        <span class="font-bold">{{ $trip->price }} درهم</span>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="bg-gray-50 rounded-lg p-4 text-center text-gray-500">
                                        لا توجد رحلات متاحة حالياً
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 