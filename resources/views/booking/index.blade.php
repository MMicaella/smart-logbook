<x-app-layout>

<x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-white tracking-wide">
            Vehicle Booking Requests
        </h2>
    </div>
</x-slot>

<style>
    
    body {
        margin: 0;
        padding: 0;

        background:
            linear-gradient(rgba(25,0,0,0.82), rgba(0,0,0,0.92)),
            url('{{ asset('images/osmena-logo.png') }}');

        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
    }


    main, nav {
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    header {
        display: none !important;
    }
</style>

<div class="min-h-screen py-10">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- FILTER CARD -->
        <div class="backdrop-blur-2xl bg-white/10 border border-white/20 rounded-2xl p-6 shadow-xl text-white">

            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search user, vehicle, reference..."
                       class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/20 text-white placeholder-white/40 focus:ring-2 focus:ring-red-500 outline-none">

                <select name="date_filter"
                        class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/20 text-white">

                    <option value="">All Dates</option>
                    <option value="today">Today</option>
                    <option value="month">This Month</option>
                    <option value="year">This Year</option>

                </select>

                <select name="status"
                        class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/20 text-white">

                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>

                </select>

                <button class="bg-blue-600 hover:bg-blue-700 transition font-semibold px-6 py-3 rounded-xl shadow-lg shadow-red-900/30">
                    Filter
                </button>

            </form>

        </div>

        <!-- TABLE CARD -->
        <div class="backdrop-blur-2xl bg-white/10 border border-white/20 rounded-2xl overflow-hidden shadow-2xl">

            <div class="overflow-x-auto">

                <table class="w-full text-sm text-white">

                    <thead class="bg-black/40 text-white uppercase text-xs tracking-wider">
                        <tr>
                            <th class="p-4 text-left">Ref</th>
                            <th class="p-4 text-left">User</th>
                            <th class="p-4 text-left">Vehicle</th>
                            <th class="p-4 text-left">Driver</th>
                            <th class="p-4 text-left">Destination</th>
                            <th class="p-4 text-left">Date & Time</th>
                            <th class="p-4 text-left">Status</th>
                            <th class="p-4 text-left">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/10">

                        @forelse($bookings as $booking)

                            <tr class="hover:bg-white/5 transition">

                                <td class="p-4 font-semibold text-white">
                                    {{ $booking->reference_number }}
                                </td>

                                <td class="p-4 text-white/90">
                                    {{ $booking->user->name ?? '-' }}
                                </td>

                                <td class="p-4 text-white/90">
                                    {{ $booking->vehicle->name ?? '-' }}
                                </td>

                                <td class="p-4 text-white/90">
                                    {{ $booking->driver->name ?? '-' }}
                                </td>

                                <td class="p-4 text-white/80">
                                    {{ $booking->destination }}
                                </td>

                                <td class="p-4">
                                    <div class="text-white/90">
                                        {{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs text-white/50">
                                        {{ \Carbon\Carbon::parse($booking->time)->format('h:i A') }}
                                    </div>
                                </td>

                                <td class="p-4">

                                    @if($booking->status == 'approved')
                                        <span class="px-3 py-1 rounded-full text-xs bg-green-500/20 text-green-300 border border-green-400/30">
                                            Approved
                                        </span>

                                    @elseif($booking->status == 'rejected')
                                        <span class="px-3 py-1 rounded-full text-xs bg-red-500/20 text-red-300 border border-red-400/30">
                                            Rejected
                                        </span>

                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs bg-yellow-500/20 text-yellow-200 border border-yellow-400/30">
                                            Pending
                                        </span>
                                    @endif

                                </td>

                                <td class="p-4">

                                    @if($booking->status == 'pending')

                                        <div class="flex gap-2">

                                            <form action="/admin/bookings/{{ $booking->id }}/approve" method="POST">
                                                @csrf
                                                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-xs shadow">
                                                    Approve
                                                </button>
                                            </form>

                                            <form action="/admin/bookings/{{ $booking->id }}/reject" method="POST">
                                                @csrf
                                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-xs shadow">
                                                    Reject
                                                </button>
                                            </form>

                                        </div>

                                    @else
                                        <span class="text-white/30 text-xs">
                                            No actions
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center p-10 text-white/40">
                                    No booking requests found.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>

    </div>
</div>

</x-app-layout>