<div class="card mt-4">
    <div class="card-header">
        <h3>Ratings</h3>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4>Average Rating: {{ number_format($user->average_rating, 1) }}/5</h4>
                <div class="ratings">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $user->average_rating ? 'text-warning' : 'text-secondary' }}"></i>
                    @endfor
                    <span class="text-muted">({{ $user->ratings->count() }} ratings)</span>
                </div>
            </div>
            <a href="{{ route('ratings.user', $user->id) }}" class="btn btn-primary">
                View All Ratings
            </a>
        </div>

        @if($latestRatings->count() > 0)
            <div class="ratings-list">
                @foreach($latestRatings as $rating)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5>{{ $rating->ratedBy->name }}</h5>
                            <div class="ratings mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $rating->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                            </div>
                            <p class="text-muted">{{ $rating->created_at->format('Y/m/d') }}</p>
                            @if($rating->comment)
                                <p>{{ $rating->comment }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                No ratings for this user yet.
            </div>
        @endif
    </div>
</div>