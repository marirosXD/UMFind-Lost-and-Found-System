@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">

    <h2 class="text-2xl font-bold mb-4">Claim History</h2>

    {{-- SEARCH FORM --}}
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.claims.index') }}" class="flex gap-2 items-center max-w-md">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search claims..."
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm">
            <button type="submit" class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-4 py-2 rounded-xl font-semibold shadow-sm hover:from-pink-600 hover:to-rose-600 transition text-sm">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.claims.index') }}" class="bg-gray-500 text-white px-3 py-2 rounded-lg hover:bg-gray-600 text-sm">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white shadow rounded overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Item</th>
                    <th class="p-3 text-left">Claimant</th>
                    <th class="p-3 text-left">Claimant Student ID</th>
                    <th class="p-3 text-left">Returner</th>
                    <th class="p-3 text-left">Returner Student ID</th>
                    <th class="p-3 text-left">Date Claimed</th>
                </tr>
            </thead>

            <tbody>
                @forelse($claims as $claim)
                <tr class="border-b cursor-pointer hover:bg-gray-50 clickable-row" data-href="{{ route('admin.claims.show', $claim) }}">

                    {{-- ITEM --}}
                    <td class="p-3">
                        {{ $claim->item->title ?? 'Deleted Item' }}
                    </td>

                    {{-- CLAIMANT --}}
                    <td class="p-3">
                        {{ $claim->claimer_first_name }} {{ $claim->claimer_last_name }}
                    </td>

                    {{-- STUDENT ID --}}
                    <td class="p-3">
                        {{ $claim->claimer_student_id }}
                    </td>

                    {{-- RETURNER --}}
                    <td class="p-3">
                        {{ trim($claim->returner_first_name . ' ' . $claim->returner_last_name) ?: 'N/A' }}
                    </td>

                    {{-- RETURNER STUDENT ID --}}
                    <td class="p-3">
                        {{ $claim->returner_student_id ?: 'N/A' }}
                    </td>

                    {{-- DATE CLAIMED --}}
                    <td class="p-3">
                        {{ optional($claim->claimed_at)->format('F j, Y H:i') ?? 'N/A' }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">
                        No claims yet.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <div class="mt-4">
        {{ $claims->links() }}
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.clickable-row').forEach(function (row) {
            row.addEventListener('click', function () {
                window.location = row.dataset.href;
            });
        });
    });
</script>
@endsection