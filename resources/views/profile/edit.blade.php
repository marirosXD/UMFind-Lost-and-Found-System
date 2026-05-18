@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Profile</h1>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full px-3 py-2 border rounded" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full px-3 py-2 border rounded" required>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection