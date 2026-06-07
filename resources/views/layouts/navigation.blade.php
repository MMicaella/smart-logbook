<nav x-data="{ open: true, mobile: false }"
     class="glass-nav sticky top-0 z-50 transition-all duration-300">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-20 items-center">

            <!-- LEFT -->
            <div class="flex items-center gap-6">

                <!-- COLLAPSE BUTTON -->
                <button @click="open = !open"
                        class="text-white text-xl hover:scale-110 transition">
                    <span x-show="open">△</span>
                    <span x-show="!open">▽</span>
                </button>

                <!-- DESKTOP MENU -->
                <div x-show="open"
                     x-transition
                     class="hidden md:flex items-center gap-4">

                    {{-- ================= DASHBOARD ================= --}}
                    <a href="{{ route('dashboard') }}"
                       class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">
                        Dashboard
                    </a>

                    {{-- ================= USER ================= --}}
                    @if(auth()->user()->role === 'user')

                        <a href="/my-borrows" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">My Borrows</a>
                        <a href="/my-bookings" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">My Bookings</a>
                        <a href="/my-requests" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">My Requests</a>

                        <a href="/borrow" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Borrow Item</a>
                        <a href="/booking" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Vehicle Booking</a>
                        <a href="/request-item" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Request Item</a>

                    @endif

                    {{-- ================= ADMIN ================= --}}
                    @if(auth()->user()->role === 'admin')

                        <a href="/admin" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Admin Panel</a>

                        <a href="/admin/borrow-requests" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Borrow Requests</a>
                        <a href="/admin/bookings" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Booking Requests</a>
                        <a href="/admin/request-items" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Item Requests</a>

                        <a href="/admin/users" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Users</a>
                        <a href="/admin/users/create" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Create Staff</a>

                        <a href="/admin/vehicles" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Vehicles</a>
                        <a href="/admin/calendar" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Calendar</a>

                        {{-- ✅ ARCHIVE (ONLY ADMIN) --}}
                        <a href="/archive" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">
                            Archive
                        </a>

                    @endif

                    {{-- ================= CUSTODIAN ================= --}}
                    @if(auth()->user()->role === 'custodian')

                        <a href="/custodian" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Borrow Releases</a>
                        <a href="/custodian/request-release" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Request Releases</a>
                        <a href="/custodian/inventory" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Inventory</a>
                        <a href="/custodian/verify" class="glass-link px-3 py-2 rounded-lg text-white hover:bg-white/10">Verify QR</a>

                    @endif

                </div>
            </div>

            <!-- RIGHT -->
            <div class="hidden md:flex items-center gap-5">

                {{-- NOTIFICATION --}}
                <a href="/notifications" class="relative text-white text-2xl">
                    🔔

                    @if(auth()->user()->unreadNotifications->count())
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>

                <!-- PROFILE -->
                <div class="relative group text-white">

                    <button class="flex items-center gap-3">

                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                 class="w-10 h-10 rounded-full border-2 border-white object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-sm font-bold">
                                {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                            </div>
                        @endif

                        <span class="font-semibold">
                            {{ Auth::user()->name }}
                        </span>

                    </button>

                    <!-- DROPDOWN -->
                    <div class="absolute right-0 mt-3 w-52 glass-card hidden group-hover:block">

                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-3 text-white hover:bg-white/10 rounded-lg">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-3 text-white hover:bg-white/10 rounded-lg">
                                Logout
                            </button>
                        </form>

                    </div>

                </div>

            </div>

            <!-- MOBILE BUTTON -->
            <div class="md:hidden">
                <button @click="mobile = !mobile"
                        class="text-3xl text-white">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="mobile"
         x-transition
         class="md:hidden glass-card mx-4 mb-4">

        <div class="flex flex-col gap-2 p-4 text-white">

            <a href="{{ route('dashboard') }}" class="glass-link">Dashboard</a>

            @if(auth()->user()->role === 'user')

                <a href="/my-borrows" class="glass-link">My Borrows</a>
                <a href="/my-bookings" class="glass-link">My Bookings</a>
                <a href="/my-requests" class="glass-link">My Requests</a>

                <a href="/borrow" class="glass-link">Borrow Item</a>
                <a href="/booking" class="glass-link">Vehicle Booking</a>
                <a href="/request-item" class="glass-link">Request Item</a>

            @endif

            @if(auth()->user()->role === 'admin')

                <a href="/admin" class="glass-link">Admin Panel</a>

                <a href="/admin/borrow-requests" class="glass-link">Borrow Requests</a>
                <a href="/admin/bookings" class="glass-link">Booking Requests</a>
                <a href="/admin/request-items" class="glass-link">Item Requests</a>

                <a href="/admin/users" class="glass-link">Users</a>
                <a href="/admin/users/create" class="glass-link">Create Staff</a>

                <a href="/admin/vehicles" class="glass-link">Vehicles</a>
                <a href="/admin/calendar" class="glass-link">Calendar</a>

                {{-- ARCHIVE --}}
                <a href="/archive" class="glass-link">Archive</a>

            @endif

            @if(auth()->user()->role === 'custodian')

                <a href="/custodian" class="glass-link">Borrow Releases</a>
                <a href="/custodian/request-release" class="glass-link">Request Releases</a>
                <a href="/custodian/inventory" class="glass-link">Inventory</a>
                <a href="/custodian/verify" class="glass-link">Verify QR</a>

            @endif

        </div>
    </div>

</nav>