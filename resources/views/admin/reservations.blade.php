@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white">الحجوزات</h2>
            <a href="{{ route('admin.dashboard') }}" class="bg-white text-blue-600 px-4 py-2 rounded-md hover:bg-blue-50 transition">
                العودة للوحة التحكم
            </a>
        </div>
        
        <div class="p-6">
            <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                <form method="GET" action="{{ route('admin.reservations') }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">تصفية حسب الحالة</label>
                        <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>جميع الحجوزات</option>
                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="accepted" {{ $status == 'accepted' ? 'selected' : '' }}>مقبولة</option>
                            <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>مرفوضة</option>
                            <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition">
                            تصفية
                        </button>
                    </div>
                </form>
            </div>

            @if($reservations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    رقم الحجز
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    المستخدم
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    الرحلة
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    السائق
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    الحالة
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    التاريخ
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    الإجراءات
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reservations as $reservation)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $reservation->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="{{ route('admin.user', $reservation->user->id) }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $reservation->user->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($reservation->trip)
                                        <a href="{{ route('trip.show', $reservation->trip->id) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $reservation->trip->from_city ?? $reservation->trip->departure_location }} إلى {{ $reservation->trip->to_city ?? $reservation->trip->destination }}
                                        </a>
                                    @else
                                        <span class="text-red-500">الرحلة غير موجودة</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($reservation->trip && $reservation->trip->driver)
                                        <a href="{{ route('admin.user', $reservation->trip->driver->id) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $reservation->trip->driver->name }}
                                        </a>
                                    @else
                                        <span class="text-red-500">غير متوفر</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($reservation->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">قيد الانتظار</span>
                                    @elseif($reservation->status == 'accepted')
                                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">مقبولة</span>
                                    @elseif($reservation->status == 'rejected')
                                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">مرفوضة</span>
                                    @elseif($reservation->status == 'cancelled')
                                        <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded">ملغاة</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $reservation->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($reservation->status == 'pending')
                                        <form action="{{ route('accept') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                            <button type="submit" class="text-green-600 hover:text-green-900 ml-2">قبول</button>
                                        </form>
                                        <form action="{{ route('reject') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                            <button type="submit" class="text-red-600 hover:text-red-900">رفض</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $reservations->appends(['status' => $status])->links() }}
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                لم يتم العثور على أي حجوزات.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 