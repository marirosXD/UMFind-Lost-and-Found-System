@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">

        <h2 class="text-xl font-bold mb-4">
            Claim Item: {{ $item->title }}
        </h2>

        <form action="{{ route('admin.items.claim.store', $item) }}" method="POST">
            @csrf

            {{-- ================= CLAIMER INFO ================= --}}
            <h3 class="font-semibold mb-2 text-gray-700">Claimant Information</h3>

            <div class="mb-3">
                <label>First Name</label>
                <input type="text" name="claimer_first_name" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" name="claimer_last_name" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-3">
                <label>Student ID</label>
                <input type="text" name="claimer_student_id" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-3">
                <label>Contact Number</label>
                <input type="text" name="claimer_contact_number" class="w-full border p-2 rounded" required>
            </div>

            <hr class="my-4">

        
            {{-- ================= ACTION BUTTONS ================= --}}
            <div class="flex justify-end gap-3 mt-4">
                <a href="{{ route('items.show', $item) }}"
                   class="bg-gray-400 text-white px-4 py-2 rounded">
                   Cancel
                </a>

                <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Confirm Claim
                </button>
            </div>

        </form>
    </div>
</div>
@endsection