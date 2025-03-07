@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Users</h3>
            <div class="flex space-x-2">
                <a href="{{ route('admin.dashboard') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Name</th>
                                <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Email</th>
                                <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Role</th>
                                <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Trips</th>
                                <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Reservations</th>
                                <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Registration Date</th>
                                <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr class="{{ $user->deleted_at ? 'bg-red-50' : '' }}">
                                <td class="py-3 px-4 text-sm">{{ $user->name }}</td>
                                <td class="py-3 px-4 text-sm">{{ $user->email }}</td>
                                <td class="py-3 px-4 text-sm">
                                    @if($user->role == 'admin')
                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Admin</span>
                                    @elseif($user->role == 'driver')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Driver</span>
                                    @else
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Passenger</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-sm">{{ $user->trips_count ?? 0 }}</td>
                                <td class="py-3 px-4 text-sm">{{ $user->reservations_count ?? 0 }}</td>
                                <td class="py-3 px-4 text-sm">{{ $user->created_at->format('Y-m-d') }}</td>
                                <td class="py-3 px-4 text-sm">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.user', $user->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-xs">View</a>
                                        @if(!$user->deleted_at)
                                            <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                            </form>
                                        @else
                                            <span class="text-red-500 text-xs">Deleted</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">No users found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection