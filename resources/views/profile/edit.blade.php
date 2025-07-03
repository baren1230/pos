@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>

        @if (session('status') === 'profile-updated')
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                Profile updated successfully.
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('name')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('email')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
@endsection
