@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h2>Ratings for {{ $user->name }}</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4>Average Rating: {{ number_format($averageRating, 1) }}/5</h4>
                            <div class="ratings">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $averageRating ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                                <span class="text-muted">({{ $ratings->total() }} ratings)</span>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('users.profile', $user->id) }}" class="btn btn-secondary">
                                Back to Profile
                            </a>
                        </div>
                    </div>

                    @if($ratings->count() > 0)
                        <div class="ratings-list">
                            @foreach($ratings as $rating)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h5>{{ $rating->ratedBy->name }}</h5>
                                                <div class="ratings mb-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $rating->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                                    @endfor
                                                </div>
                                                <p class="text-muted">
                                                    {{ $rating->created_at->format('Y/m/d') }}
                                                    - Trip from {{ $rating->trip->from }} to {{ $rating->trip->to }}
                                                </p>
                                                @if($rating->comment)
                                                    <p>{{ $rating->comment }}</p>
                                                @endif
                                            </div>
                                            
                                            @if (Auth::id() === $rating->rated_by || Auth::user()->isAdmin())
                                                <div>
                                                    <form action="{{ route('ratings.destroy', $rating->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this rating?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $ratings->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            No ratings for this user yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection