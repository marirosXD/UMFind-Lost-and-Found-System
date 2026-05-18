@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-pink-50/30 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Items</h1>
                <p class="text-gray-500 mt-1">Manage your posted items</p>
            </div>
            <a href="{{ route('items.create') }}" class="btn-primary">
                + Post New Item
            </a>
        </div>
        
        <!-- Items Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($items as $item)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                    @if($item->image)
                        <img src="{{ $item->image_url }}" class="w-full h-48 object-cover" alt="{{ $item->title }}">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-pink-100 to-rose-100 flex items-center justify-center">
                            <span class="text-4xl">🔍</span>
                        </div>
                    @endif
                    
                    <div class="px-6 pt-5 pb-5">
                        <div class="flex justify-between items-start gap-2 mb-3">
                            <h3 class="text-lg font-bold text-gray-900">{{ $item->title }}</h3>
                            <span class="px-2 py-1 text-xs rounded-full {{ $item->status === 'claimed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($item->description, 100) }}</p>
                        
                        <div class="space-y-2 mb-5">
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="mr-2">📍</span> {{ $item->location }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="mr-2">📅</span> 
                                Found: {{ \Carbon\Carbon::parse($item->date_found)->format('M d, Y') }}
                            </div>
                        </div>
                        
                        <div class="flex gap-2 mb-4">  <!-- Added mb-4 for space BELOW buttons -->
                            <a href="{{ route('items.edit', $item) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-600 transition">Edit</a>
                            
                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600 transition" onclick="return confirm('Delete this item?')">Delete</button>
                            </form>

                            <a href="{{ route('items.show', $item) }}" class="text-pink-500 hover:text-pink-600 text-sm font-medium flex items-center">
                                View
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <div class="text-6xl mb-4">📦</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No items posted yet</h3>
                    <p class="text-gray-500">You haven't posted any items.</p>
                    <a href="{{ route('items.create') }}" class="btn-primary inline-block mt-4">Post Your First Item</a>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection