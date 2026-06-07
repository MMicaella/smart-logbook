<x-app-layout>

<x-slot name="header">
    <div class="glass-header">
        <h2 class="text-2xl font-bold text-white">
            Borrow Requests
        </h2>
    </div>
</x-slot>

<style>
    body {
        background:
            linear-gradient(rgba(25,0,0,0.88), rgba(10,0,0,0.95)),
            url('/images/osmena-logo.png');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
    }

    main,
    nav,
    header {
        background: transparent !important;
        box-shadow: none !important;
    }

    .glass {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(26px);
    }

    .btn {
        padding: 8px 14px;
        border-radius: 12px;
        font-size: .8rem;
        font-weight: 600;
        transition: .2s;
    }

    .btn-approve {
        background: rgba(34,197,94,.15);
        color: #4ade80;
        border: 1px solid rgba(74,222,128,.25);
    }

    .btn-approve:hover {
        background: rgba(34,197,94,.25);
    }

    .btn-reject {
        background: rgba(239,68,68,.15);
        color: #f87171;
        border: 1px solid rgba(248,113,113,.25);
    }

    .btn-reject:hover {
        background: rgba(239,68,68,.25);
    }

    .btn-view {
        background: rgba(59,130,246,.15);
        color: #60a5fa;
        border: 1px solid rgba(96,165,250,.25);
    }

    .btn-view:hover {
        background: rgba(59,130,246,.25);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        text-align: left;
        padding: 14px;
        font-size: .75rem;
        color: rgba(255,255,255,.65);
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255,255,255,.08);
        white-space: nowrap;
    }

    td {
        padding: 14px;
        color: rgba(255,255,255,.88);
        border-bottom: 1px solid rgba(255,255,255,.05);
        vertical-align: top;
    }

    tr:hover {
        background: rgba(255,255,255,.03);
    }

    .purpose-cell {
        max-width: 250px;
        word-wrap: break-word;
        white-space: normal;
    }
</style>

<div class="min-h-screen py-12">

    <div class="max-w-7xl mx-auto px-4">

        <div class="glass rounded-2xl p-6 text-white">

            {{-- HEADER --}}
            <div class="flex justify-between items-center mb-6">

                <h3 class="text-lg font-semibold text-white/90">
                    Latest Borrow Requests
                </h3>

                <a href="/admin/borrow/all"
                   class="btn btn-view">
                    View All
                </a>

            </div>

            <div class="overflow-x-auto">

                <table>

                    <thead>
                        <tr>
                            <th>Reference</th>
                            {{-- <th>User</th> --}}
                            <th>Department</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Location</th>
                            <th>Purpose</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($borrows->take(5) as $borrow)

                        <tr>

                            <td class="font-semibold">
                                {{ $borrow->reference_number }}
                            </td>

                            <td>
                                {{ $borrow->user->department ?? 'Unknown' }}
                            </td>

                            {{-- <td>
                                {{ $borrow->department ?? '-' }}
                            </td> --}}

                            <td>
                                {{ $borrow->item->item_name ?? '-' }}
                            </td>

                            <td>
                                {{ $borrow->quantity }}
                            </td>

                            <td>

                                @if($borrow->borrow_location == 'outside')

                                    <span class="text-blue-400 font-semibold">
                                        Outside
                                    </span>

                                @else

                                    <span class="text-green-400 font-semibold">
                                        Inside
                                    </span>

                                @endif

                            </td>

                            <td class="purpose-cell">
                                {{ $borrow->purpose }}
                            </td>

                            <td>
                                {{ $borrow->created_at->format('M d, Y h:i A') }}
                            </td>

                            <td>

                                @if($borrow->status == 'approved')

                                    <span class="text-green-400">
                                        Approved
                                    </span>

                                @elseif($borrow->status == 'rejected')

                                    <span class="text-red-400">
                                        Rejected
                                    </span>

                                @else

                                    <span class="text-yellow-400">
                                        Pending
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($borrow->status == 'pending')

                                    <div class="flex gap-2">

                                        <form method="POST"
                                              action="/admin/borrow/{{ $borrow->id }}/approve">

                                            @csrf

                                            <button class="btn btn-approve">
                                                Approve
                                            </button>

                                        </form>

                                        <form method="POST"
                                              action="/admin/borrow/{{ $borrow->id }}/reject">

                                            @csrf

                                            <button class="btn btn-reject">
                                                Reject
                                            </button>

                                        </form>

                                    </div>

                                @else

                                    <span class="text-white/30 text-sm">
                                        Done
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="10"
                                class="text-center py-10 text-white/40">

                                No borrow requests found.

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