@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
        <p class="text-gray-600">Welcome back, <strong>{{ auth()->user()->name }}</strong>!</p>
        
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-blue-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Your Items</h3>
                <p class="text-gray-600">Manage your posted items</p>
                <a href="{{ route('my-items') }}" class="inline-block mt-4 text-blue-600 hover:text-blue-800">
                    View My Items →
                </a>
            </div>
            
            <div class="bg-green-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Post New Item</h3>
                <p class="text-gray-600">Report a lost or found item</p>
                <a href="{{ route('items.create') }}" class="inline-block mt-4 text-green-600 hover:text-green-800">
                    Post Item →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection