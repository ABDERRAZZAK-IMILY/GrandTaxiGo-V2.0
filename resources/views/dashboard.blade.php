<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            @if(auth()->user()->role === 'passenger')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-xl font-semibold mb-4">{{ __('messages.my_reservations') }}</h2>
                        <!-- محتوى الحجوزات -->
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold">تقييماتي</h2>
                            <a href="{{ route('ratings.user', auth()->id()) }}" class="text-yellow-500 hover:text-yellow-700">
                                عرض الكل <i class="fas fa-arrow-left mr-1"></i>
                            </a>
                        </div>
                        
                        @php
                            $ratings = \App\Models\Rating::where('user_id', auth()->id())
                                ->with(['ratedBy', 'trip'])
                                ->orderBy('created_at', 'desc')
                                ->take(3)
                                ->get();
                            $averageRating = auth()->user()->average_rating ?? 0;
                        @endphp
                        
                        <div class="mb-4">
                            <div class="flex items-center mb-2">
                                <div class="text-lg font-medium ml-2">متوسط التقييم: {{ number_format($averageRating, 1) }}/5</div>
                                <div class="flex">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $averageRating ? 'text-yellow-400' : 'text-gray-300' }} ml-1"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        
                        @if($ratings->count() > 0)
                            <div class="space-y-4">
                                @foreach($ratings as $rating)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex justify-between">
                                            <div>
                                                <div class="font-medium">{{ $rating->ratedBy->name }}</div>
                                                <div class="flex my-1">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }} ml-1"></i>
                                                    @endfor
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $rating->created_at->format('Y/m/d') }}
                                                    - رحلة من {{ $rating->trip->from }} إلى {{ $rating->trip->to }}
                                                </div>
                                                @if($rating->comment)
                                                    <p class="mt-2 text-gray-700">{{ $rating->comment }}</p>
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
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
