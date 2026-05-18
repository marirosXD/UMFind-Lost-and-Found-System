@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-pink-50/30 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit User</h1>
                <p class="text-gray-500 text-sm mt-1">Update user information and role</p>
            </div>
            <a href="{{ route('admin.users') }}" class="flex items-center gap-2 text-gray-600 hover:text-pink-500 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Users
            </a>
        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-5">
                    <label for="name" class="label">Full Name</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $user->name) }}"
                           class="input-field @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-5">
                    <label for="email" class="label">Email Address</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', $user->email) }}"
                           class="input-field @error('email') border-red-500 @enderror"
                           required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mb-5">
                    <label for="role" class="label">Role</label>
                    <select name="role" 
                            id="role" 
                            class="input-field @error('role') border-red-500 @enderror"
                            required>
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-400 text-xs mt-1">
                        <span class="font-medium">Admin</span> - Full access to all features including user management<br>
                        <span class="font-medium">User</span> - Can only post and manage their own items
                    </p>
                </div>

                <!-- Password (Optional) -->
                <div class="mb-5">
                    <label for="password" class="label">New Password (Optional)</label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="input-field"
                           placeholder="Leave blank to keep current password">
                    <p class="text-gray-400 text-xs mt-1">Only fill if you want to change the password</p>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="label">Confirm New Password</label>
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           class="input-field"
                           placeholder="Confirm new password">
                </div>

                <!-- User Stats Card -->
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-3">User Statistics</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Member since:</span>
                            <span class="text-gray-900 font-medium ml-2">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Items posted:</span>
                            <span class="text-gray-900 font-medium ml-2">{{ $user->items->count() }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Last updated:</span>
                            <span class="text-gray-900 font-medium ml-2">{{ $user->updated_at->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">User ID:</span>
                            <span class="text-gray-900 font-medium ml-2">#{{ $user->id }}</span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 justify-end">
                    <a href="{{ route('admin.users') }}" class="btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        Update User
                    </button>
                </div>
            </form>
        </div>

        <!-- Danger Zone (Only for non-self users) -->
        @if(auth()->id() != $user->id)
        <div class="mt-6 bg-red-50 rounded-2xl p-6 border border-red-200">
            <h3 class="text-red-800 font-semibold mb-2">Danger Zone</h3>
            <p class="text-red-600 text-sm mb-4">Once deleted, this action cannot be undone.</p>
            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This will also delete all their items.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-xl hover:bg-red-600 transition">
                    Delete User
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection