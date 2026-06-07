<x-app-layout>

<x-slot name="header">
    <div class="glass-header">
        <h2 class="text-2xl font-bold text-white">
            Archive - Borrow Requests
        </h2>
    </div>
</x-slot>

<style>
    body {
        background:
            linear-gradient(rgba(25,0,0,0.88), rgba(10,0,0,0.95)),
            url('/images/osmena-logo.png');
        background-size: contain;
        background-position: center;
        background-attachment: fixed;
    }

    main, nav, header {
        background: transparent !important;
        box-shadow: none !important;
    }

    .glass {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(26px);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        text-align: left;
        padding: 14px;
        font-size: 0.75rem;
        color: rgba(255,255,255,0.65);
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    td {
        padding: 14px;
        color: rgba(255,255,255,0.88);
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    tr:hover {
        background: rgba(255,255,255,0.03);
    }
</style>

<div class="min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4">

        <div class="glass rounded-2xl p-6 text-white">

            {{-- <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold">Archived Requests</h3>
                <a href="/admin/borrow" class="text-blue-300 hover:underline">
                    ← Back
                </a>
            </div> --}}

            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>User</th>
                            <th>Department</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($borrows as $borrow)
                        <tr>
                            <td class="font-semibold">{{ $borrow->reference_number }}</td>
                            <td>{{ $borrow->user->name ?? 'Unknown' }}</td>
                            <td>{{ $borrow->department ?? '-' }}</td>
                            <td>{{ $borrow->item->item_name ?? '-' }}</td>
                            <td>{{ $borrow->quantity }}</td>

                            <td>
                                @if($borrow->status == 'approved')
                                    <span class="text-green-400">Approved</span>
                                @else
                                    <span class="text-red-400">Rejected</span>
                                @endif
                            </td>

                            <td>{{ $borrow->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-white/40">
                                No archived records.
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