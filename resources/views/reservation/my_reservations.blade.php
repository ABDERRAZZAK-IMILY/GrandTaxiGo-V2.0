@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4" dir="rtl">
    <div class="flex justify-center">
        <div class="w-full">
            <div class="bg-white rounded-lg shadow-md">
                <div class="border-b p-4">
                    <h4 class="text-xl font-bold text-right">حجوزاتي</h4>
                </div>
                <div class="p-4">
                    @if($reservations->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="border p-2 text-right">رقم الحجز</th>
                                        <th class="border p-2 text-right">من</th>
                                        <th class="border p-2 text-right">إلى</th>
                                        <th class="border p-2 text-right"> التاريخ و الوقت</th>
                                        <th class="border p-2 text-right">عدد المقاعد</th>
                                        <th class="border p-2 text-right">الحالة</th>
                                        <th class="border p-2 text-right">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border p-2">{{ $reservation->id }}</td>
                                        <td class="border p-2">{{ $reservation->trip->departure_location }}</td>
                                        <td class="border p-2">{{ $reservation->trip->destination }}</td>
                                        <td class="border p-2">{{ $reservation->trip->departure_time }}</td>
                                        <td class="border p-2">{{ $reservation->trip->available_seats }}</td>
                                        <td class="border p-2">
                                            @if($reservation->status == 'pending')
                                                <span class="px-2 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">قيد الانتظار</span>
                                            @elseif($reservation->status == 'accepted')
                                                <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">مؤكد</span>
                                            @elseif($reservation->status == 'cancelled')
                                                <span class="px-2 py-1 text-sm rounded-full bg-red-100 text-red-800">ملغى</span>
                                            @endif
                                        </td>
                                        <td class="border p-2">
                                            @if($reservation->status == 'pending')
                                                <form action="" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600  px-3 py-1 rounded text-sm" >
                                                        إلغاء
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('show', $reservation->id) }}" class="bg-blue-500 hover:bg-blue-600  px-3 py-1 rounded text-sm mr-2">
                                                التفاصيل
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-blue-100 text-blue-800 p-4 text-center rounded">
                            لا توجد حجوزات حالياً
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection