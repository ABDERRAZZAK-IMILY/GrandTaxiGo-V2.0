@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card mb-4">
        <div class="card-header">
            <h3>User Details</h3>
        </div>
        <div class="card-body">
            <h4>{{ $user->name }}</h4>
            <p>Email: {{ $user->email }}</p>
            <p>Role: {{ ucfirst($user->role) }}</p>
            <p>Joined: {{ $user->created_at->format('M d, Y') }}</p>
            
            <h5>Ratings</h5>
            @if($ratings->count() > 0)
                <ul>
                    @foreach($ratings as $rating)
                        <li>
                            Rating: {{ $rating->rating }} - Comment: {{ $rating->comment }} - By: {{ $rating->ratedBy->name }} - On: {{ $rating->created_at->format('M d, Y') }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No ratings found.</p>
            @endif

            <h5>Trips</h5>
            @if($trips->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Trip ID</th>
                                <th>Driver</th>
                                <th>Passengers</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trips as $trip)
                            <tr>
                                <td>{{ $trip->id }}</td>
                                <td>{{ $trip->driver->name }}</td>
                                <td>
                                    @foreach($trip->reservations as $reservation)
                                        {{ $reservation->user->name }}<br>
                                    @endforeach
                                </td>
                                <td>{{ $trip->created_at->format('M d, Y') }}</td>
                                <td>{{ ucfirst($trip->status) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $trips->links() }}
            @else
                <p>No trips found.</p>
            @endif
        </div>
    </div>
</div>
@endsection