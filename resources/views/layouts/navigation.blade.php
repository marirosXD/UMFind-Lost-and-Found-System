<nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-pink-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center space-x-2 cursor-pointer">
                <div class="w-9 h-9 bg-gradient-to-r from-pink-500 to-rose-500 rounded-xl flex items-center justify-center shadow-sm">
                    <span class="text-white text-lg">🔍</span>
                </div>
                <span class="text-xl font-bold bg-gradient-to-r from-pink-600 to-rose-600 bg-clip-text text-transparent">UMFind</span>
            </a>

            <!-- Desktop Nav Links -->
            <div class="hidden md:flex items-center space-x-8">
                @auth
                    <a href="{{ route('dashboard') }}"
                    class="text-gray-600 hover:text-pink-500 transition {{ request()->routeIs('dashboard') ? 'text-pink-500 font-semibold border-b-2 border-pink-500' : '' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('items.index') }}"
                    class="text-gray-600 hover:text-pink-500 transition {{ request()->routeIs('items.index') ? 'text-pink-500 font-semibold border-b-2 border-pink-500' : '' }}">
                        Browse
                    </a>

                    {{-- Regular users only --}}
                    @if(!auth()->user()->isAdmin())
                        <a href="{{ route('items.create') }}"
                        class="text-gray-600 hover:text-pink-500 transition {{ request()->routeIs('items.create') ? 'text-pink-500 font-semibold border-b-2 border-pink-500' : '' }}">
                            Post Item
                        </a>

                        <a href="{{ route('my-items') }}"
                        class="text-gray-600 hover:text-pink-500 transition {{ request()->routeIs('my-items') ? 'text-pink-500 font-semibold border-b-2 border-pink-500' : '' }}">
                            My Items
                        </a>
                    @endif

                    {{-- Admin only --}}
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                        class="text-gray-600 hover:text-pink-500 transition {{ request()->routeIs('admin.dashboard') ? 'text-pink-500 font-semibold border-b-2 border-pink-500' : '' }}">
                            Manage Items & Users
                        </a>

                        <a href="{{ route('admin.claims.index') }}"
                        class="text-gray-700 hover:text-pink-500 transition {{ request()->routeIs('admin.claims.index') ? 'text-pink-500 font-semibold border-b-2 border-pink-500' : '' }}">
                            Claim History
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-3">
                @auth
                    <div class="relative">
                        <button id="userDropdownBtn"
                                onclick="toggleUserDropdown()"
                                class="flex items-center space-x-2 bg-gray-50 hover:bg-gray-100 px-4 py-2 rounded-xl transition cursor-pointer">
                            <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <span class="text-gray-700 text-sm">{{ explode(' ', auth()->user()->name)[0] }}</span>
                            <svg id="dropdownArrow" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg z-50 border border-gray-100">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 rounded-t-xl transition">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-red-500 hover:bg-pink-50 rounded-b-xl transition">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="{{ request()->routeIs('login') ? 'text-pink-500 font-semibold border-b-2 border-pink-500' : 'text-gray-600 hover:text-pink-500' }} transition-all duration-200">
                        Sign In
                    </a>

                    <a href="{{ route('register') }}"
                       class="{{ request()->routeIs('register') ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white px-4 py-2 rounded-xl shadow-md ring-2 ring-pink-400' : 'btn-primary text-sm' }} transition-all duration-200">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleUserDropdown() {
        const dropdown = document.getElementById('userDropdown');
        const arrow = document.getElementById('dropdownArrow');

        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            if (arrow) arrow.style.transform = 'rotate(180deg)';
        } else {
            dropdown.classList.add('hidden');
            if (arrow) arrow.style.transform = 'rotate(0deg)';
        }
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        const button = document.getElementById('userDropdownBtn');

        if (dropdown && button && !button.contains(event.target)) {
            dropdown.classList.add('hidden');
            const arrow = document.getElementById('dropdownArrow');
            if (arrow) arrow.style.transform = 'rotate(0deg)';
        }
    });
</script>

<style>
    body { padding-top: 0; }
</style>