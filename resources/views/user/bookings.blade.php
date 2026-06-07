<x-app-layout>

<style>
    /* ===============================
       🔥 GLOBAL FIX (MATCH BORROW UI)
    =============================== */

    .min-h-screen.bg-gray-100 {
        background: transparent !important;
    }

    body {
        background:
            linear-gradient(rgba(30,0,0,0.82), rgba(0,0,0,0.88)),
            url('/images/osmena-logo.png');

        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
    }

    header {
        background: transparent !important;
        box-shadow: none !important;
    }

    /* GLASS STYLE (same as borrow page) */
    .glass-card {
        background: rgba(255, 255, 255, 0.10);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.35);
    }

    table {
        color: white !important;
    }

    th {
        color: rgba(255,255,255,0.9);
    }

    td {
        color: rgba(255,255,255,0.85);
    }
</style>

<div class="max-w-6xl mx-auto py-10">

    <h2 class="text-2xl font-bold mb-6 text-white">
        My Vehicle Bookings
    </h2>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="mb-5 px-4 py-3 rounded-lg bg-green-500/20 text-green-200 border border-green-400/30">
            {{ session('success') }}
        </div>
    @endif

    <!-- GLASS TABLE -->
    <div class="glass-card overflow-hidden">

        <table class="w-full text-sm text-left">

            <thead class="bg-white/10 text-white uppercase text-xs">

                <tr>
                    <th class="px-6 py-4">Reference No.</th>
                    <th class="px-6 py-4">Vehicle</th>
                    <th class="px-6 py-4">Schedule</th>
                    <th class="px-6 py-4">Destination</th>
                    <th class="px-6 py-4">Status</th>
                </tr>

            </thead>

            <tbody class="divide-y divide-white/10">

                @forelse($bookings as $booking)

                    <tr class="hover:bg-white/10 transition">

                        <!-- REF -->
                        <td class="px-6 py-4 font-semibold">
                            {{ $booking->reference_number }}
                        </td>

                        <!-- VEHICLE -->
                        <td class="px-6 py-4">
                            <div class="font-semibold">
                                {{ $booking->vehicle->name ?? '-' }}
                            </div>
                            <div class="text-xs text-white/60">
                                {{ $booking->vehicle->plate_number ?? '' }}
                            </div>
                        </td>

                        <!-- SCHEDULE -->
                        <td class="px-6 py-4">
                            <div>
                                {{ \Carbon\Carbon::parse($booking->date)->format('F d, Y') }}
                            </div>
                            <div class="text-xs text-white/60">
                                {{ \Carbon\Carbon::parse($booking->time)->format('h:i A') }}
                            </div>
                        </td>

                        <!-- DESTINATION -->
                        <td class="px-6 py-4">
                            {{ $booking->destination }}
                        </td>

                        <!-- STATUS -->
                        <td class="px-6 py-4">

                            @if($booking->status == 'approved')
                                <span class="px-3 py-1 text-xs rounded-full bg-green-500/20 text-green-200 border border-green-400/30">
                                    Approved
                                </span>

                            @elseif($booking->status == 'rejected')
                                <span class="px-3 py-1 text-xs rounded-full bg-red-500/20 text-red-200 border border-red-400/30">
                                    Rejected
                                </span>

                            @else
                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-200 border border-yellow-400/30">
                                    Pending
                                </span>
                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center py-10 text-white/60">
                            No booking records found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</x-app-layout>