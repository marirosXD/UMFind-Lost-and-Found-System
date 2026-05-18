@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">

            @if($item->image)
                <img src="{{ $item->image_url }}"
                    class="w-full h-96 object-cover cursor-pointer hover:opacity-90 transition"
                    alt="{{ $item->title }}"
                    onclick="openImageModal(this.src)">
            @endif

            <div class="p-6">

                @if(auth()->check() && auth()->user()->isAdmin())
                    <div class="mb-4">
                        <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                            ← Back to Recent Items
                        </a>
                    </div>
                @endif
                

                {{-- TITLE + STATUS --}}
                <div class="flex justify-between items-start mb-4">
                    <h1 class="text-3xl font-bold">{{ $item->title }}</h1>

                    <span class="px-3 py-1 rounded-full text-sm
                        {{ $item->status === 'claimed'
                            ? 'bg-green-100 text-green-800'
                            : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>

           

                {{-- DETAILS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-600"><strong>Category:</strong> {{ ucfirst($item->category) }}</p>
                        <p class="text-gray-600"><strong>Location:</strong> {{ $item->location }}</p>
                        <p class="text-gray-600"><strong>Date Found:</strong> {{ $item->date_found->format('F j, Y') }}</p>
                    </div>

                    <div>
                        <p class="text-gray-600"><strong>Posted by:</strong> {{ $item->user->name }}</p>
                        <p class="text-gray-600"><strong>Posted on:</strong> {{ $item->created_at->format('F j, Y') }}</p>
                    </div>
                </div>

                {{-- DESCRIPTION --}}
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-2">Description</h3>
                    <p class="text-gray-700">{{ $item->description }}</p>
                </div>





                
                @if($item->attachment)
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold mb-2">Attachment</h3>

                        <a href="{{ asset('storage/' . $item->attachment) }}" target="_blank"
                        class="text-blue-600 hover:underline">
                            View Attached File (PDF / Document)
                        </a>
                    </div>
                @endif

                {{-- ACTIONS --}}
<div class="flex flex-wrap gap-3 items-center justify-between">
    <div class="flex gap-3">
        @auth
            {{-- EDIT + DELETE --}}
            @if($item->status !== 'claimed' && (auth()->id() === $item->user_id || auth()->user()->isAdmin()))
                <a href="{{ route('items.edit', $item) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Edit
                </a>

                <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                            onclick="return confirm('Delete this item?')">
                        Delete
                    </button>
                </form>
            @endif

           {{-- ADMIN ACTIONS --}}
@auth
@if(auth()->user()->isAdmin())

    {{-- STILL MISSING → SHOW ITEM RECEIVED --}}
   @if($item->status === 'still_missing')
    <a href="{{ route('admin.items.return.form', $item) }}"
       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Item Received
    </a>
@endif

    {{-- RECEIVED → SHOW PROCESS CLAIM --}}
    @if($item->status === 'received')
        <a href="{{ route('admin.items.claim.form', $item) }}"
           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Process Claim
        </a>
    @endif

@endif
@endauth
    @endauth
    </div>

    <a href="{{ route('items.index') }}"
       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
        Back to List
    </a>
</div>

            </div>
        </div>
    </div>
</div>

@endsection