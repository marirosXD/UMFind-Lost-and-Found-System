@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-pink-50/30 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <div class="text-center mb-8">
                <div class="w-14 h-14 bg-gradient-to-r from-pink-500 to-rose-500 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <span class="text-white text-2xl">🔍</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Create account</h2>
                <p class="text-gray-500 text-sm mt-1">Join ClaimSpot today</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="mb-4">
                <label class="label">Student ID</label>
                    <input type="text" name="student_id" class="input-field" required>
                </div>
                
                <div class="mb-4">
                    <label class="label">First name</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" required
                           class="input-field" placeholder="John">
                    @error('first_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                 <div class="mb-4">
                    <label class="label">Last name</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" required
                           class="input-field" placeholder="Perez">
                    @error('last_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-4">
                    <label class="label">Contact Number</label>
                    <input type="text" name="contact_number" class="w-full border p-2 rounded" required>
                </div>

                
                <div class="mb-4">
                    <label class="label">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="input-field" placeholder="hello@example.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="label">Password</label>
                    <input type="password" name="password" required
                           class="input-field" placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label class="label">Confirm password</label>
                    <input type="password" name="password_confirmation" required
                           class="input-field" placeholder="••••••••">
                </div>
                
                <button type="submit" class="btn-primary w-full py-3">
                    Create Account
                </button>
            </form>
            
            <p class="text-center text-gray-600 text-sm mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-pink-500 hover:text-pink-600 font-medium">Sign in</a>
            </p>
        </div>
    </div>
</div>
@endsection