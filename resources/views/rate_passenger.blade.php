@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Rate Passenger</h2>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h4>Trip Details</h4>
                        <p>
                            <strong>From:</strong> {{ $trip->from }}<br>
                            <strong>To:</strong> {{ $trip->to }}<br>
                            <strong>Date:</strong> {{ $trip->date->format('Y/m/d') }}<br>
                            <strong>Passenger:</strong> {{ $passenger->name }}
                        </p>
                    </div>

                    <form action="{{ route('ratings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $passenger->id }}">
                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                        
                        <div class="form-group mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <div class="rating">
                                <div class="d-flex">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" required>
                                            <label class="form-check-label" for="rating{{ $i }}">{{ $i }}</label>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            @error('rating')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="comment" class="form-label">Comment (Optional)</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3">{{ old('comment') }}</textarea>
                            @error('comment')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit Rating</button>
                            <a href="{{ route('trip.show', $trip->id) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection