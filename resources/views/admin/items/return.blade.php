@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">

        <h2 class="text-xl font-bold mb-4">
            Item Received: {{ $item->title }}
        </h2>

        <form method="POST" action="{{ route('admin.items.return.store', ['item' => $item->id]) }}">
        @csrf

            {{-- ================= RETURNER INFO ================= --}}
            <h3 class="font-semibold mb-2 text-gray-700">
                Returner Information (Person who submitted the item)
            </h3>

            <div class="mb-3">
                <label>First Name</label>
                <input type="text" name="returner_first_name"
                       class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" name="returner_last_name"
                       class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-3">
                <label>Student ID</label>
                <input type="text" name="returner_student_id"
                       class="w-full border p-2 rounded">
            </div>

            <div class="mb-3">
                <label>Contact Number</label>
                <input type="text" name="returner_contact"
                       class="w-full border p-2 rounded">
            </div>

            <hr class="my-4">

            {{-- OPTIONAL NOTE --}}
            <div class="mb-3">
                <label>Additional Notes (Optional)</label>
                <textarea name="notes"
                          class="w-full border p-2 rounded"
                          rows="3"
                          placeholder="Any details about where/how the item was found..."></textarea>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex justify-end gap-3 mt-4">
                <a href="{{ route('items.show', $item) }}"
                   class="bg-gray-400 text-white px-4 py-2 rounded">
                   Cancel
                </a>

                <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Confirm return
                </button>
            </div>

        </form>
    </div>
</div>
@endsection