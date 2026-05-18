@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-pink-50/30 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Lost & Found Items</h1>
                <p class="text-gray-500 mt-1">Browse through all reported items</p>
            </div>
            @auth
                <a href="{{ route('items.create') }}" class="btn-primary">
                    + Post New Item
                </a>
            @endauth
        </div>

        <!-- FILTER FORM -->
        <form method="GET" action="{{ route('items.index') }}" class="mb-6 flex gap-2 flex-wrap items-center">

            <input type="hidden" name="tab" value="{{ request('tab') }}">

            <input type="text"
                name="search"
                placeholder="Search items..."
                value="{{ request('search') }}"
                class="border border-gray-200 p-2 rounded-xl w-full max-w-md focus:outline-none focus:ring-2 focus:ring-pink-400">

            <select name="category"
                class="border border-gray-200 p-2 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400">

                <option value="">All Categories</option>
                <option value="electronics">Electronics</option>
                <option value="documents">Documents</option>
                <option value="jewelry">Jewelry</option>
                <option value="clothing">Clothing</option>
                <option value="bags">Bags</option>
                <option value="keys">Keys</option>
                <option value="pets">Pets</option>
                <option value="other">Other</option>
            </select>

            <button type="submit"
                class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-4 py-2 rounded-xl font-semibold shadow-sm hover:from-pink-600 hover:to-rose-600 transition">
                Search
            </button>
        </form>

        <!-- TABS -->
        <div class="mb-6 flex gap-3">

            <a href="{{ route('items.index', ['tab' => 'lost']) }}"
            class="px-4 py-2 rounded-xl {{ request('tab', 'lost') !== 'admin' ? 'bg-pink-500 text-white' : 'bg-gray-200' }}">
                Lost Items
            </a>

            <a href="{{ route('items.index', ['tab' => 'admin']) }}"
            class="px-4 py-2 rounded-xl {{ request('tab') === 'admin' ? 'bg-pink-500 text-white' : 'bg-gray-200' }}">
                Lost Items at Admin Office
            </a>

        </div>

        <!-- ITEMS GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($items as $item)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">

    <!-- IMAGE (RESTORED ORIGINAL STYLE) -->
                @if($item->image)
                    <img src="{{ $item->image_url }}" class="w-full h-48 object-cover" alt="{{ $item->title }}">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-pink-100 to-rose-100 flex items-center justify-center">
                        <span class="text-4xl">🔍</span>
                    </div>
                @endif

                <div class="px-6 pt-5 pb-5">

                    <!-- TITLE + STATUS (RESTORED) -->
                    <div class="flex justify-between items-start gap-2 mb-3">

                        <h3 class="text-lg font-bold text-gray-900">
                            {{ $item->title }}
                        </h3>

                        @php
                            $statusClass = match($item->status) {
                                'still_missing' => 'bg-red-100 text-red-700',
                                'received' => 'bg-yellow-100 text-yellow-700',
                                'claimed' => 'bg-green-100 text-green-700',
                                default => 'bg-gray-100 text-gray-700'
                            };

                            $statusLabel = match($item->status) {
                                'still_missing' => 'Still Missing',
                                'received' => 'At Admin Office',
                                'claimed' => 'Claimed',
                                default => ucfirst($item->status)
                            };
                        @endphp

                        <span class="px-2 py-1 text-xs rounded-full {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>

                    </div>

                    <!-- DESCRIPTION -->
                    <p class="text-gray-600 text-sm mb-4">
                        {{ \Illuminate\Support\Str::limit($item->description, 100) }}
                    </p>

                    <!-- DETAILS -->
                    <div class="space-y-2 mb-6">

                        <div class="flex items-center text-sm text-gray-500">
                            <span class="mr-2">📍</span> {{ $item->location }}
                        </div>

                        <div class="flex items-center text-sm text-gray-500">
                            <span class="mr-2">📅</span>
                            {{ $item->status === 'found' ? 'Received:' : 'Found:' }}
                            {{ \Carbon\Carbon::parse($item->date_found)->format('M d, Y') }}
                        </div>

                        <div class="flex items-center text-sm text-gray-500">
                            <span class="mr-2">👤</span> {{ $item->user->name }}
                        </div>

                    </div>


                    <!-- VIEW DETAILS (SAFE + SIMPLE) -->
                    <div class="flex justify-end">
                        <a href="{{ url('/items/' . $item->id) }}"
                        class="inline-flex items-center text-pink-500 hover:text-pink-600 font-medium text-sm">

                            View Details

                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>

                        </a>
                    </div>

                </div>
            </div>

            
            @empty
                <div class="col-span-3 text-center py-12">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No items found</h3>
                    <p class="text-gray-500">Be the first to post an item!</p>

                    @auth
                        <a href="{{ route('items.create') }}" class="btn-primary inline-block mt-4">
                            Post an Item
                        </a>
                    @endauth
                </div>
            @endforelse

        </div>

        <!-- PAGINATION -->
        <div class="mt-8">
            {{ $items->links() }}
        </div>

    </div>
</div>
@endsection