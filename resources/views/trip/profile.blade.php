<x-app-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Driver Profile</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ $driver->profile_pictures ?? asset('images/default-avatar.jpg') }}" 
                                     class="img-fluid rounded-circle" alt="Driver Photo">
                            </div>
                            <div class="col-md-8">
                                <h3>{{ $driver->name ?? 'Driver Name' }}</h3>
                                <p><strong>Email:</strong> {{ $driver->email ?? 'email@example.com' }}</p>
                                <p><strong>Phone:</strong> {{ $driver->phone ?? 'Not provided' }}</p>
                                <p><strong>License Number:</strong> {{ $driver->license_number ?? 'Not provided' }}</p>
                                <p><strong>Vehicle:</strong> {{ $driver->vehicle->model ?? 'Not provided' }}</p>
                                <p><strong>Rating:</strong> 
                                    <span class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= ($driver->rating ?? 0))
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </span>
                                    ({{ $driver->rating ?? '0' }}/5)
                                </p>
                                <p><strong>Completed Trips:</strong> {{ $driver->trips_count ?? '0' }}</p>
                            </div>
                        </div>

                        @if(auth()->id() === ($driver->user_id ?? null))
                            <div class="mt-3">
                                <a href="{{ route('driver.edit') }}" class="btn btn-primary">
                                    Edit Profile
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
