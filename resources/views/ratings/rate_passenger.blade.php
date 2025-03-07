@extends('layouts.app')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-yellow-500 text-white px-6 py-4">
                <h2 class="text-xl font-bold">Rate Passenger</h2>
            </div>
            
            <div class="p-6">
                <div class="mb-6 bg-gray-50 rounded-lg p-4">
                    <h4 class="font-semibold text-lg mb-2">Trip Details</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">From:</p>
                            <p class="font-medium">{{ $trip->departure_location }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">To:</p>
                            <p class="font-medium">{{ $trip->destination }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Date:</p>
                            <p class="font-medium">{{ $trip->departure_time }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Passenger:</p>
                            <p class="font-medium">{{ $passenger->name }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('ratings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $passenger->id }}">
                    <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                    
                    <div class="mb-6">
                        <label for="rating" class="block text-gray-700 font-medium mb-2">Rating</label>
                        <div class="flex flex-row-reverse justify-center space-x-4 space-x-reverse mb-2">
                            @for ($i = 5; $i >= 1; $i--)
                                <div class="rating-item">
                                    <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" class="hidden" required>
                                    <label for="rating{{ $i }}" class="text-4xl cursor-pointer star-label" data-rating="{{ $i }}">
                                        <i class="far fa-star"></i>
                                    </label>
                                </div>
                            @endfor
                        </div>
                        @error('rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="comment" class="block text-gray-700 font-medium mb-2">Comment (Optional)</label>
                        <textarea class="w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200" 
                            id="comment" name="comment" rows="3" placeholder="Tell us about your experience with this passenger...">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('trip.show', $trip->id) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition">
                            Cancel
                        </a>
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-6 rounded-md transition">
                            Submit Rating
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingItems = document.querySelectorAll('.rating-item');
    
    ratingItems.forEach(item => {
        const input = item.querySelector('input');
        const label = item.querySelector('label');
        
        if (input.checked) {
            updateStars(parseInt(input.value));
        }
        
        label.addEventListener('click', function() {
            updateStars(parseInt(this.dataset.rating));
        });
    });
    
    function updateStars(rating) {
        ratingItems.forEach(item => {
            const label = item.querySelector('label');
            const starValue = parseInt(label.dataset.rating);
            const starIcon = label.querySelector('i');
            
            if (starValue <= rating) {
                starIcon.className = 'fas fa-star text-yellow-400';
            } else {
                starIcon.className = 'far fa-star text-gray-400';
            }
        });
    }
});
</script>
@endsection 