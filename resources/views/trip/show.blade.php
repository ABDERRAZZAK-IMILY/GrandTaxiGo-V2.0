@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white">تفاصيل الرحلة</h2>
            <div class="flex space-x-2 rtl:space-x-reverse">
                @if(auth()->user() && auth()->user()->role === 'driver' && $trip->driver_id === auth()->id())
                    <a href="{{ route('dashboard') }}" class="bg-white text-yellow-600 px-4 py-2 rounded-md hover:bg-yellow-50 transition">
                        العودة للوحة التحكم
                    </a>
                @elseif(auth()->user() && auth()->user()->role === 'admin')
                    <a href="{{ route('admin.trips') }}" class="bg-white text-yellow-600 px-4 py-2 rounded-md hover:bg-yellow-50 transition">
                        العودة لقائمة الرحلات
                    </a>
                @else
                    <a href="{{ url()->previous() }}" class="bg-white text-yellow-600 px-4 py-2 rounded-md hover:bg-yellow-50 transition">
                        العودة
                    </a>
                @endif
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-yellow-50 rounded-lg p-6 shadow">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">معلومات الرحلة</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">نقطة الانطلاق:</span>
                            <span class="font-semibold">{{ $trip->departure_location }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">الوجهة:</span>
                            <span class="font-semibold">{{ $trip->destination }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">تاريخ ووقت الانطلاق:</span>
                            <span class="font-semibold">{{ $trip->departure_time->format('Y-m-d H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">المقاعد المتاحة:</span>
                            <span class="font-semibold">{{ $trip->available_seats }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">حالة الرحلة:</span>
                            <span class="font-semibold">
                                @if($trip->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">قيد الانتظار</span>
                                @elseif($trip->status == 'active')
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">نشطة</span>
                                @elseif($trip->status == 'completed')
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">مكتملة</span>
                                @elseif($trip->status == 'cancelled')
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">ملغاة</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 rounded-lg p-6 shadow">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">معلومات السائق</h3>
                    
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-yellow-200 flex items-center justify-center mr-4">
                            <span class="text-2xl font-bold text-yellow-600">{{ substr($trip->driver->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold">{{ $trip->driver->name }}</h4>
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($trip->driver->average_rating ?? 0))
                                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500 ml-1">({{ $trip->driver->average_rating ?? 0 }})</span>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('trip.driverProfile', $trip->driver_id) }}" class="block w-full bg-yellow-500 hover:bg-yellow-600 text-white text-center py-2 px-4 rounded-md transition">
                        عرض ملف السائق
                    </a>
                </div>
            </div>
            
            @if(auth()->user() && auth()->user()->role === 'passenger' && $trip->status === 'active')
                <div class="bg-white border border-yellow-200 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">حجز مقعد</h3>
                    
                    @if($trip->available_seats > 0)
                        <form action="{{ route('reservation.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 mb-2">المقاعد المتاحة: <span class="font-semibold">{{ $trip->available_seats }}</span></p>
                                    <p class="text-gray-600">سعر المقعد: <span class="font-semibold">100 درهم</span></p>
                                </div>
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-6 rounded-md transition">
                                    حجز مقعد
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="bg-red-100 text-red-700 p-4 rounded-md">
                            <p class="font-semibold">عذراً، لا توجد مقاعد متاحة لهذه الرحلة.</p>
                        </div>
                    @endif
                </div>
            @endif
            
            @if(auth()->user() && auth()->user()->role === 'admin')
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">الحجوزات</h3>
                    
                    @if($trip->reservations->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-3 px-4 bg-gray-100 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">المسافر</th>
                                        <th class="py-3 px-4 bg-gray-100 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">الحالة</th>
                                        <th class="py-3 px-4 bg-gray-100 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">تاريخ الحجز</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($trip->reservations as $reservation)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <a href="{{ route('admin.user', $reservation->user->id) }}" class="text-blue-600 hover:text-blue-900">
                                                    {{ $reservation->user->name }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if($reservation->status == 'pending')
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">قيد الانتظار</span>
                                                @elseif($reservation->status == 'accepted')
                                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">مقبول</span>
                                                @elseif($reservation->status == 'rejected')
                                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">مرفوض</span>
                                                @elseif($reservation->status == 'cancelled')
                                                    <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded">ملغي</span>
                                                @elseif($reservation->status == 'completed')
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">مكتمل</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                {{ $reservation->created_at->format('Y-m-d H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">لا توجد حجوزات لهذه الرحلة.</p>
                    @endif
                </div>
            @endif
            
            @if(auth()->user() && auth()->user()->role === 'driver' && $trip->driver_id === auth()->id())
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">الحجوزات المعلقة ({{ $pendingReservations->count() }})</h3>
                    
                    @if($pendingReservations->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-3 px-4 bg-gray-100 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">المسافر</th>
                                        <th class="py-3 px-4 bg-gray-100 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">تاريخ الحجز</th>
                                        <th class="py-3 px-4 bg-gray-100 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($pendingReservations as $reservation)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                {{ $reservation->user->name }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                {{ $reservation->created_at->format('Y-m-d H:i') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="flex space-x-2 rtl:space-x-reverse">
                                                    <form action="{{ route('accept') }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded-md text-xs">قبول</button>
                                                    </form>
                                                    
                                                    <form action="{{ route('reject') }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-xs">رفض</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">لا توجد حجوزات معلقة لهذه الرحلة.</p>
                    @endif
                </div>
                
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">جميع الحجوزات</h3>
                    
                    @if($trip->reservations->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-3 px-4 bg-gray-100 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">المسافر</th>
                                        <th class="py-3 px-4 bg-gray-100 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">الحالة</th>
                                        <th class="py-3 px-4 bg-gray-100 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">تاريخ الحجز</th>
                                        <th class="py-3 px-4 bg-gray-100 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($trip->reservations as $reservation)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                {{ $reservation->user->name }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if($reservation->status == 'pending')
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">قيد الانتظار</span>
                                                @elseif($reservation->status == 'accepted')
                                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">مقبول</span>
                                                @elseif($reservation->status == 'rejected')
                                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">مرفوض</span>
                                                @elseif($reservation->status == 'cancelled')
                                                    <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded">ملغي</span>
                                                @elseif($reservation->status == 'completed')
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">مكتمل</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                {{ $reservation->created_at->format('Y-m-d H:i') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if($reservation->status == 'completed')
                                                    <a href="{{ route('ratings.rate_passenger', ['trip_id' => $trip->id, 'user_id' => $reservation->user_id]) }}" 
                                                       class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded-md text-xs">
                                                        تقييم الراكب
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">لا توجد حجوزات لهذه الرحلة.</p>
                    @endif
                </div>
            @endif
            
            @if(auth()->user() && auth()->user()->role === 'passenger')
                @php
                    $userReservation = $trip->reservations->where('user_id', auth()->id())->first();
                @endphp
                
                @if($userReservation && $userReservation->status === 'completed')
                    <div class="bg-white border border-yellow-200 rounded-lg p-6 mb-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">تقييم السائق</h3>
                        
                        @php
                            $existingRating = \App\Models\Rating::where('trip_id', $trip->id)
                                ->where('rated_by', auth()->id())
                                ->where('user_id', $trip->driver_id)
                                ->first();
                        @endphp
                        
                        @if($existingRating)
                            <div class="bg-green-100 text-green-700 p-4 rounded-md mb-4">
                                <p class="font-semibold">لقد قمت بتقييم هذا السائق مسبقاً.</p>
                                <div class="flex mt-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $existingRating->rating ? 'text-yellow-400' : 'text-gray-300' }} ml-1"></i>
                                    @endfor
                                    <span class="text-sm text-gray-500 mr-2">({{ $existingRating->rating }})</span>
                                </div>
                                @if($existingRating->comment)
                                    <p class="mt-2 text-sm">{{ $existingRating->comment }}</p>
                                @endif
                            </div>
                        @else
                            <a href="{{ route('ratings.rate_driver', $trip->id) }}" class="block w-full bg-yellow-500 hover:bg-yellow-600 text-white text-center py-2 px-4 rounded-md transition">
                                تقييم السائق
                            </a>
                        @endif
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection 