<x-app-layout>

<style>

/* ===============================
   🔥 REMOVE BREEZE HEADER COMPLETELY
=============================== */

header,
nav,
.bg-white,
.shadow,
.shadow-sm,
.dark\:bg-gray-800,
.dark\:bg-gray-900 {
    background: transparent !important;
    box-shadow: none !important;
    border: none !important;
}

/* kill Breeze container background */
.min-h-screen.bg-gray-100 {
    background: transparent !important;
}

/* ===============================
   🔥 GLOBAL BACKGROUND
=============================== */

body {
    background:
        linear-gradient(rgba(25,0,0,0.82), rgba(0,0,0,0.90)),
        url('{{ asset('images/osmena-logo.png') }}');

    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
}

/* ===============================
   🔥 GLASS CARD
=============================== */

.glass-card {
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 22px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.35);
    transition: 0.3s ease;
}

.glass-card:hover {
    transform: translateY(-3px);
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.20);
}

/* ===============================
   🔥 STAT CARDS
=============================== */

.stat-title {
    color: rgba(255,255,255,0.75);
    font-size: 0.95rem;
    font-weight: 600;
}

.stat-number {
    font-size: 2.2rem;
    font-weight: 800;
    margin-top: 10px;
}

/* ===============================
   🔥 QUICK ACTION BUTTONS
=============================== */

.action-btn {
    padding: 12px 18px;
    border-radius: 14px;
    font-weight: 600;
    font-size: 0.9rem;
    color: white;
    transition: 0.25s ease;
    display: inline-block;
    border: 1px solid transparent;
}

.action-btn:hover {
    transform: translateY(-3px);
    filter: brightness(1.1);
}

/* COLORS */
.btn-blue { background: rgba(59,130,246,0.25); border-color: rgba(59,130,246,0.3); }
.btn-green { background: rgba(34,197,94,0.25); border-color: rgba(34,197,94,0.3); }
.btn-red { background: rgba(239,68,68,0.25); border-color: rgba(239,68,68,0.3); }
.btn-purple { background: rgba(168,85,247,0.25); border-color: rgba(168,85,247,0.3); }
.btn-pink { background: rgba(236,72,153,0.25); border-color: rgba(236,72,153,0.3); }

</style>

<!-- HEADER SLOT -->
<x-slot name="header">

    <div class="glass-card p-6">

        <h2 class="text-3xl font-bold text-white">
            Admin Dashboard
        </h2>

        <p class="text-white/60 mt-2">
            System overview and management control panel
        </p>

    </div>

</x-slot>

<div class="py-10 px-4">

    <div class="max-w-7xl mx-auto">

        <!-- STATS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="glass-card p-6">
                <h3 class="stat-title">Total Users</h3>
                <p class="stat-number text-blue-300">
                    {{ \App\Models\User::count() }}
                </p>
            </div>

            <div class="glass-card p-6">
                <h3 class="stat-title">Vehicle Bookings</h3>
                <p class="stat-number text-green-300">
                    {{ \App\Models\Booking::count() }}
                </p>
            </div>

            <div class="glass-card p-6">
                <h3 class="stat-title">Borrow Requests</h3>
                <p class="stat-number text-red-300">
                    {{ \App\Models\Borrow::count() }}
                </p>
            </div>

        </div>

        <!-- QUICK ACTIONS -->
        <div class="mt-10 glass-card p-6">

            <h3 class="text-xl font-bold text-white mb-5">
                Quick Actions
            </h3>

            <div class="flex flex-wrap gap-4">

                <a href="/admin/bookings" class="action-btn btn-blue">
                    Manage Bookings
                </a>

                <a href="/admin/calendar" class="action-btn btn-green">
                    Booking Calendar
                </a>

                <a href="/admin/borrow-requests" class="action-btn btn-red">
                    Manage Borrows
                </a>

                <a href="/admin/request-items" class="action-btn btn-purple">
                    Manage Requests
                </a>

                <a href="/admin/users" class="action-btn btn-pink">
                    Manage Users
                </a>

            </div>

        </div>

    </div>

</div>

</x-app-layout>