@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold">Claim Details</h2>
                <p class="text-sm text-gray-600 mt-1">Review claimant, returner, and item information.</p>
            </div>
            <a href="{{ route('admin.claims.index') }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Back to Claim History
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="bg-gray-50 rounded-lg p-5 border">
                <h3 class="text-lg font-semibold mb-4">Item Information</h3>
                <p class="text-gray-700"><strong>Title:</strong> {{ $claim->item->title ?? 'Deleted Item' }}</p>
                <p class="text-gray-700"><strong>Category:</strong> {{ ucfirst($claim->item->category ?? 'N/A') }}</p>
                <p class="text-gray-700"><strong>Location Found:</strong> {{ $claim->item->location ?? 'N/A' }}</p>
                <p class="text-gray-700"><strong>Date Found:</strong> {{ optional($claim->item->date_found)->format('F j, Y') ?? 'N/A' }}</p>
                <p class="text-gray-700"><strong>Status:</strong> {{ ucfirst($claim->item->status ?? 'N/A') }}</p>
                <p class="text-gray-700"><strong>Posted by:</strong> {{ $claim->item->user->name ?? 'N/A' }}</p>
                <p class="text-gray-700"><strong>Posted on:</strong> {{ optional($claim->item->created_at)->format('F j, Y') ?? 'N/A' }}</p>
                <div class="mt-4">
                    <h4 class="font-semibold">Description</h4>
                    <p class="text-gray-700">{{ $claim->item->description ?? 'No description available.' }}</p>
                </div>
                @if($claim->item->image)
                <div class="mt-4">
                    <h4 class="font-semibold">Image</h4>
                    <img src="{{ $claim->item->image_url }}" class="w-full max-w-sm h-auto rounded border mt-2" alt="{{ $claim->item->title ?? 'Item Image' }}">
                </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="bg-gray-50 rounded-lg p-5 border">
                    <h3 class="text-lg font-semibold mb-4">Claimant Information</h3>
                    <p class="text-gray-700"><strong>Name:</strong> {{ $claim->claimer_first_name }} {{ $claim->claimer_last_name }}</p>
                    <p class="text-gray-700"><strong>Student ID:</strong> {{ $claim->claimer_student_id }}</p>
                    <p class="text-gray-700"><strong>Contact:</strong> {{ $claim->claimer_contact }}</p>
                    <p class="text-gray-700"><strong>Claimed at:</strong> {{ optional($claim->claimed_at)->format('F j, Y H:i') ?? 'N/A' }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-5 border">
                    <h3 class="text-lg font-semibold mb-4">Returner Information</h3>
                    <p class="text-gray-700"><strong>Name:</strong> {{ trim($claim->returner_first_name . ' ' . $claim->returner_last_name) ?: 'N/A' }}</p>
                    <p class="text-gray-700"><strong>Student ID:</strong> {{ $claim->returner_student_id ?: 'N/A' }}</p>
                    <p class="text-gray-700"><strong>Contact:</strong> {{ $claim->returner_contact ?: 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
