@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white">تفاصيل المستخدم</h2>
            <a href="{{ route('admin.users') }}" class="bg-white text-blue-600 px-4 py-2 rounded-md hover:bg-blue-50 transition">
                العودة لقائمة المستخدمين
            </a>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="md:col-span-1 bg-blue-50 rounded-lg p-6 shadow">
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                            <span class="text-3xl font-bold text-blue-600">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $user->name }}</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @if($user->role == 'admin') bg-purple-100 text-purple-800
                            @elseif($user->role == 'driver') bg-green-100 text-green-800
                            @else bg-blue-100 text-blue-800 @endif">
                            @if($user->role == 'admin') مدير
                            @elseif($user->role == 'driver') سائق
                            @else راكب @endif
                        </span>
                        
                        <div class="w-full mt-6 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">البريد الإلكتروني:</span>
                                <span class="font-medium">{{ $user->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">تاريخ الانضمام:</span>
                                <span class="font-medium">{{ $user->created_at->format('Y-m-d') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">عدد الرحلات:</span>
                                <span class="font-medium">{{ $trips->total() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">متوسط التقييم:</span>
                                <span class="font-medium flex items-center">
                                    @if($ratings->count() > 0)
                                        {{ number_format($ratings->avg('rating'), 1) }}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        لا يوجد
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                        <div class="px-6 py-4 bg-gray-50 border-b">
                            <h3 class="text-lg font-semibold text-gray-800">التقييمات</h3>
                        </div>
                        <div class="p-6">
                            @if($ratings->count() > 0)
                                <div class="space-y-4">
                                    @foreach($ratings as $rating)
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <div class="flex items-center mb-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                    <p class="text-gray-700">{{ $rating->comment }}</p>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <div>بواسطة: {{ $rating->ratedBy->name }}</div>
                                                    <div>{{ $rating->created_at->format('Y-m-d') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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
                                                لا توجد تقييمات لهذا المستخدم.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">الرحلات</h3>
                </div>
                <div class="p-6">
                    @if($trips->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            رقم الرحلة
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            المسار
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            التاريخ
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            الحالة
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            الإجراءات
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($trips as $trip)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $trip->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $trip->from_city }} إلى {{ $trip->to_city }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $trip->departure_time->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($trip->status == 'scheduled')
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">مجدولة</span>
                                            @elseif($trip->status == 'completed')
                                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">مكتملة</span>
                                            @elseif($trip->status == 'cancelled')
                                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">ملغاة</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('trip.show', $trip->id) }}" class="text-indigo-600 hover:text-indigo-900">عرض</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $trips->links() }}
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
                                        لم يتم العثور على أي رحلات لهذا المستخدم.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection