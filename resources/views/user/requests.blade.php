<x-app-layout>

<style>
    /* ===============================
       🔥 GLOBAL FIX (MATCH ALL UI PAGES)
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

    /* GLASS CARD */
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
        My Item Requests
    </h2>

    <!-- GLASS TABLE -->
    <div class="glass-card overflow-hidden">

        <table class="w-full text-sm text-left">

            <thead class="bg-white/10 text-white uppercase text-xs">

                <tr>
                    <th class="p-4">Ref #</th>
                    <th class="p-4">Item</th>
                    <th class="p-4">Quantity</th>
                    <th class="p-4">Purpose</th>
                    <th class="p-4">Status</th>
                </tr>

            </thead>

            <tbody class="divide-y divide-white/10">

                @forelse($requests as $request)

                    <tr class="hover:bg-white/10 transition">

                        <!-- REF -->
                        <td class="p-4 font-semibold">
                            {{ $request->reference_number }}
                        </td>

                        <!-- ITEM -->
                        <td class="p-4">
                            {{ $request->item->item_name ?? 'Unknown Item' }}
                        </td>

                        <!-- QUANTITY -->
                        <td class="p-4">
                            {{ $request->quantity }}
                        </td>

                        <!-- PURPOSE -->
                        <td class="p-4 text-white/80">
                            {{ $request->purpose }}
                        </td>

                        <!-- STATUS -->
                        <td class="p-4">

                            @if($request->status == 'approved')
                                <span class="px-3 py-1 text-xs rounded-full bg-green-500/20 text-green-200 border border-green-400/30">
                                    Approved
                                </span>

                            @elseif($request->status == 'rejected')
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
                            No requests found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</x-app-layout>