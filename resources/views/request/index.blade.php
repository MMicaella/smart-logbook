<x-app-layout>

<x-slot name="header">
    <div class="glass-header">
        <h2 class="text-2xl font-bold text-white">
            Item Requests
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

    main, nav, header {
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    /* GLASS BLOCK */
    .glass-block {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(28px);
    }

    /* INPUTS + SELECT FIX */
    .glass-input {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.10);
        color: white;
        border-radius: 14px;
        padding: 12px;
        width: 100%;
        outline: none;

        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    .glass-input:focus {
        border-color: rgba(255,80,80,0.5);
        box-shadow: 0 0 0 3px rgba(255,0,0,0.10);
    }

    /* 🔥 FIX DROPDOWN TEXT VISIBILITY */
    .glass-input option {
        background: #1a0000;
        color: white;
    }

    /* BUTTON */
    .btn-filter {
        background: linear-gradient(to right, #7f1d1d, #991b1b);
        color: white;
        border-radius: 14px;
        font-weight: 600;
        transition: 0.2s;
        padding: 12px;
        width: 100%;
    }

    .btn-filter:hover {
        transform: scale(1.02);
    }

    /* TABLE */
    table {
        width: 100%;
        border-collapse: collapse;
        background: transparent;
    }

    thead {
        background: rgba(255,255,255,0.03);
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

    tbody tr:hover {
        background: rgba(255,255,255,0.03);
    }

    .table-wrap {
        overflow-x: auto;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }

    .badge-approved {
        background: rgba(34,197,94,0.10);
        color: #4ade80;
        border: 1px solid rgba(74,222,128,0.25);
    }

    .badge-rejected {
        background: rgba(239,68,68,0.10);
        color: #f87171;
        border: 1px solid rgba(248,113,113,0.25);
    }

    .badge-pending {
        background: rgba(234,179,8,0.10);
        color: #facc15;
        border: 1px solid rgba(250,204,21,0.25);
    }

    .btn {
        padding: 8px 14px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .btn-approve {
        background: rgba(34,197,94,0.15);
        color: #4ade80;
        border: 1px solid rgba(74,222,128,0.25);
    }

    .btn-reject {
        background: rgba(239,68,68,0.15);
        color: #f87171;
        border: 1px solid rgba(248,113,113,0.25);
    }
</style>

<div class="min-h-screen py-12">

    <div class="max-w-7xl mx-auto px-4">

        {{-- FILTER SECTION --}}
        <div class="glass-block rounded-2xl p-5 mb-6 text-white">

            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search reference, user, item..."
                       class="glass-input">

                <select name="date_filter" class="glass-input">
                    <option value="">All Dates</option>
                    <option value="today" {{ request('date_filter')=='today'?'selected':'' }}>Today</option>
                    <option value="month" {{ request('date_filter')=='month'?'selected':'' }}>This Month</option>
                    <option value="year" {{ request('date_filter')=='year'?'selected':'' }}>This Year</option>
                </select>

                <select name="status" class="glass-input">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                    <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
                    <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
                </select>

                <button class="btn-filter">
                    Filter
                </button>

            </form>

        </div>

        {{-- TABLE SECTION --}}
        <div class="glass-block rounded-2xl p-6 text-white">

            @if(session('success'))
                <div class="mb-5 bg-green-500/15 border border-green-400/25 text-green-200 p-4 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-wrap">

                <table>

                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>User</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Purpose</th>
                            <th>Fund Source</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($requests as $request)

                        <tr>

                            <td class="font-semibold">{{ $request->reference_number }}</td>

                            <td>{{ $request->user->name ?? '-' }}</td>

                            <td>
                                <div class="font-medium">{{ $request->item->item_name ?? '-' }}</div>
                                <div class="text-xs text-white/50">{{ $request->item->category ?? '' }}</div>
                            </td>

                            <td>{{ $request->quantity }}</td>

                            <td>{{ $request->purpose }}</td>

                            <td>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/5 border border-white/10 text-white/70">
                                    {{ $request->fund_source }}
                                </span>
                            </td>

                            <td>
                                @if($request->status == 'approved')
                                    <span class="badge badge-approved">Approved</span>
                                @elseif($request->status == 'rejected')
                                    <span class="badge badge-rejected">Rejected</span>
                                @else
                                    <span class="badge badge-pending">Pending</span>
                                @endif
                            </td>

                            <td class="text-center">

                                @if($request->status == 'pending')

                                    <div class="flex justify-center gap-2">

                                        <form method="POST" action="/admin/request-item/{{ $request->id }}/approve">
                                            @csrf
                                            <button class="btn btn-approve">Approve</button>
                                        </form>

                                        <form method="POST" action="/admin/request-item/{{ $request->id }}/reject">
                                            @csrf
                                            <button class="btn btn-reject">Reject</button>
                                        </form>

                                    </div>

                                @else
                                    <span class="text-white/30 text-xs">No Actions</span>
                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="8" class="text-center py-10 text-white/40">
                                No requests found.
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