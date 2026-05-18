@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-pink-50/30 py-8">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        




    <!-- Stats Cards (FIXED LAYOUT) -->
<div style="display: flex; gap: 1rem; margin-bottom: 2rem; width: 100%;">
    <div style="flex: 1;" class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Users</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
            </div>
            <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                👤
            </div>
        </div>
    </div>

    <div style="flex: 1;" class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Items</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalItems }}</p>
            </div>
            <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                📦
            </div>
        </div>
    </div>

    <div style="flex: 1;" class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Still Missing</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stillMissingItems }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                ⏳
            </div>
        </div>
    </div>

    <div style="flex: 1;" class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Items at Admin</p>
                <p class="text-3xl font-bold text-gray-900">{{ $receivedItems }}</p>
            </div>
            <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                📦
            </div>
        </div>
    </div>

    <div style="flex: 1;" class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Claimed Items</p>
                <p class="text-3xl font-bold text-gray-900">{{ $claimedItems }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                ✔
            </div>
        </div>
    </div>
</div>


        

        <!-- Bottom Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Recent Items -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Items</h2>

                <!-- FILTER (Dashboard Version) -->
                <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4 flex gap-2 flex-wrap items-center">

                    <input type="text"
                        name="search"
                        placeholder="Search items..."
                        value="{{ request('search') }}"
                        class="border border-gray-200 p-2 rounded-xl w-full max-w-xs focus:outline-none focus:ring-2 focus:ring-pink-400">

                    <select name="category"
                        class="border border-gray-200 p-2 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400">

                        <option value="">All</option>
                        <option value="electronics" {{ request('category')=='electronics'?'selected':'' }}>Electronics</option>
                        <option value="documents" {{ request('category')=='documents'?'selected':'' }}>Documents</option>
                        <option value="jewelry" {{ request('category')=='jewelry'?'selected':'' }}>Jewelry</option>
                        <option value="clothing" {{ request('category')=='clothing'?'selected':'' }}>Clothing</option>
                        <option value="bags" {{ request('category')=='bags'?'selected':'' }}>Bags</option>
                        <option value="keys" {{ request('category')=='keys'?'selected':'' }}>Keys</option>
                        <option value="pets" {{ request('category')=='pets'?'selected':'' }}>Pets</option>
                        <option value="other" {{ request('category')=='other'?'selected':'' }}>Other</option>
                    </select>

                    <button type="submit"
                        class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-4 py-2 rounded-xl text-sm hover:from-pink-600 hover:to-rose-600 transition">
                        Search
                    </button>

                </form>




                <div class="flex gap-2 mb-4 flex-wrap">

                <a href="{{ route('admin.dashboard', ['status' => 'all', 'search' => request('search'), 'category' => request('category')]) }}"
                class="px-3 py-1 rounded-xl text-sm {{ request('status') == 'all' || !request('status') ? 'bg-pink-500 text-white' : 'bg-gray-200' }}">
                    All
                </a>

                <a href="{{ route('admin.dashboard', ['status' => 'still_missing', 'search' => request('search'), 'category' => request('category')]) }}"
                class="px-3 py-1 rounded-xl text-sm {{ request('status') == 'still_missing' ? 'bg-red-500 text-white' : 'bg-gray-200' }}">
                    Still Missing
                </a>

                <a href="{{ route('admin.dashboard', ['status' => 'received', 'search' => request('search'), 'category' => request('category')]) }}"
                class="px-3 py-1 rounded-xl text-sm {{ request('status') == 'received' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                    At Admin Office
                </a>

                <a href="{{ route('admin.dashboard', ['status' => 'claimed', 'search' => request('search'), 'category' => request('category')]) }}"
                class="px-3 py-1 rounded-xl text-sm {{ request('status') == 'claimed' ? 'bg-green-500 text-white' : 'bg-gray-200' }}">
                    Claimed
                </a>

            </div>
                


                <div class="space-y-3">
                    @foreach($recentItems as $item)


                    
                    <div onclick="window.location='{{ route('items.show', $item->id) }}'"
     class="flex items-center justify-between py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer rounded-xl px-2">

    <div>
        <p class="font-medium text-gray-900">{{ $item->title }}</p>

        <p class="text-sm text-gray-500">
            by {{ $item->user->name }} • {{ $item->created_at->diffForHumans() }}
        </p>


    </div>

    @php
        $statusClass = match($item->status) {
            'still_missing' => 'bg-red-100 text-red-700',
            'received' => 'bg-blue-100 text-blue-700',
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
                    @endforeach
                </div>
            </div>

            <!-- Recent Users -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Users</h2>

                <div class="space-y-3">
                    @foreach($recentUsers as $user)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-medium">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>

                            <div>
                                <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>

                        <a href="{{ route('admin.users.edit', $user->id) }}"
                           class="text-pink-500 hover:text-pink-600 text-sm font-medium">
                            Manage →
                        </a>

                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
</div>



<script>
    // Save scroll position before reload
    window.addEventListener("beforeunload", function () {
        localStorage.setItem("scrollPosition", window.scrollY);
    });

    // Restore scroll position after reload
    window.addEventListener("load", function () {
        const scrollPosition = localStorage.getItem("scrollPosition");
        if (scrollPosition !== null) {
            window.scrollTo(0, parseInt(scrollPosition));
            localStorage.removeItem("scrollPosition");
        }
    });
</script>

@endsection