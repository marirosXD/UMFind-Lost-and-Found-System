@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-pink-50/30 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <div class="text-center mb-8">
                <div class="w-14 h-14 bg-gradient-to-r from-pink-500 to-rose-500 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <span class="text-white text-2xl">🔍</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Welcome back</h2>
                <p class="text-gray-500 text-sm mt-1">Sign in to your account</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="label">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="input-field" placeholder="hello@example.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label class="label">Password</label>
                    <input type="password" name="password" required
                           class="input-field" placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-pink-500 focus:ring-pink-400">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-pink-500 hover:text-pink-600">Forgot password?</a>
                </div>
                
                <button type="submit" class="btn-primary w-full py-3">
                    Sign In
                </button>
            </form>
            
            <p class="text-center text-gray-600 text-sm mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-pink-500 hover:text-pink-600 font-medium">Create one</a>
            </p>
        </div>
    </div>
</div>
@endsection