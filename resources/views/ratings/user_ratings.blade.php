@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-yellow-500 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold">تقييمات {{ $user->name }}</h2>
                <a href="{{ route('users.profile', $user->id) }}" class="bg-white text-yellow-500 hover:bg-yellow-100 py-1 px-4 rounded-md text-sm transition">
                    العودة للملف الشخصي
                </a>
            </div>
            
            <div class="p-6">
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-4 md:mb-0">
                            <h4 class="text-lg font-semibold">متوسط التقييم: {{ number_format($averageRating, 1) }}/5</h4>
                            <div class="flex mt-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $averageRating ? 'text-yellow-400' : 'text-gray-300' }} ml-1 text-xl"></i>
                                @endfor
                                <span class="text-gray-500 mr-2">({{ $ratings->total() }} تقييم)</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            @if($user->role === 'driver')
                                <div class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">
                                    <i class="fas fa-car ml-1"></i> سائق
                                </div>
                            @elseif($user->role === 'passenger')
                                <div class="bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full">
                                    <i class="fas fa-user ml-1"></i> راكب
                                </div>
                            @elseif($user->role === 'admin')
                                <div class="bg-purple-100 text-purple-800 text-sm font-semibold px-3 py-1 rounded-full">
                                    <i class="fas fa-user-shield ml-1"></i> مسؤول
                                </div>
                            @endif
                            
                            <div class="mr-3 text-gray-500 text-sm">
                                <i class="fas fa-calendar-alt ml-1"></i> انضم {{ $user->created_at->format('Y/m/d') }}
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($ratings->count() > 0)
                    <div class="space-y-4">
                        @foreach($ratings as $rating)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex justify-between">
                                    <div class="flex items-start">
                                        <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500 ml-3">
                                            <i class="fas fa-user text-xl"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center">
                                                <h5 class="font-medium text-lg">{{ $rating->ratedBy->name }}</h5>
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
                                            <div class="text-sm text-gray-500 mb-2">
                                                <i class="fas fa-calendar-alt ml-1"></i> {{ $rating->created_at->format('Y/m/d') }}
                                                <span class="mx-2">|</span>
                                                <i class="fas fa-route ml-1"></i> رحلة من {{ $rating->trip->from }} إلى {{ $rating->trip->to }}
                                            </div>
                                            @if($rating->comment)
                                                <div class="bg-gray-50 p-3 rounded-md mt-2">
                                                    <p class="text-gray-700">{{ $rating->comment }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if (Auth::id() === $rating->rated_by)
                                        <div>
                                            <form action="{{ route('ratings.destroy', $rating->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition" 
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا التقييم؟')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $ratings->links() }}
                    </div>
                @else
                    <div class="bg-gray-50 rounded-lg p-8 text-center">
                        <div class="text-gray-400 text-5xl mb-4">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-500 mb-2">لا توجد تقييمات</h3>
                        <p class="text-gray-400">لم يتم تقييم هذا المستخدم بعد</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 