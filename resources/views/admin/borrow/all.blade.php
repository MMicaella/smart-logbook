<x-app-layout>

<x-slot name="header">
    <div class="glass-header">
        <h2 class="text-2xl font-bold text-white">
            All Borrow Requests
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

    .glass-input {
        background: rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.15);
        color: white;
        border-radius: 14px;
        padding: 12px;
        width: 100%;
        outline: none;
    }

    .glass-input::placeholder {
        color: rgba(255,255,255,0.5);
    }

    select.glass-input option {
        background: #1a0000;
        color: white;
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
    }

    td {
        padding: 14px;
        color: rgba(255,255,255,.88);
        border-bottom: 1px solid rgba(255,255,255,.05);
    }

    tr:hover {
        background: rgba(255,255,255,.03);
    }

    .btn-close {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: rgba(239,68,68,.15);
        border: 1px solid rgba(248,113,113,.25);
        color: #f87171;
        font-weight: bold;
        text-decoration: none;
        transition: .2s;
    }

    .btn-close:hover {
        transform: scale(1.05);
    }
</style>

<div class="min-h-screen py-12">

    <div class="max-w-7xl mx-auto px-4">

        {{-- FILTER CARD --}}
        <div class="glass rounded-2xl p-5 mb-6 text-white">

            <form method="GET"
                  action="{{ url()->current() }}"
                  class="grid grid-cols-1 md:grid-cols-4 gap-3">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search user, item, department, reference..."
                    class="glass-input">

                <select
                    name="date_filter"
                    class="glass-input">

                    <option value="">All Dates</option>

                    <option value="today"
                        {{ request('date_filter') == 'today' ? 'selected' : '' }}>
                        Today
                    </option>

                    <option value="month"
                        {{ request('date_filter') == 'month' ? 'selected' : '' }}>
                        This Month
                    </option>

                    <option value="year"
                        {{ request('date_filter') == 'year' ? 'selected' : '' }}>
                        This Year
                    </option>

                </select>

                <select
                    name="status"
                    class="glass-input">

                    <option value="">All Status</option>

                    <option value="pending"
                        {{ request('status') == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="approved"
                        {{ request('status') == 'approved' ? 'selected' : '' }}>
                        Approved
                    </option>

                    <option value="rejected"
                        {{ request('status') == 'rejected' ? 'selected' : '' }}>
                        Rejected
                    </option>

                    <option value="released"
                        {{ request('status') == 'released' ? 'selected' : '' }}>
                        Released
                    </option>

                </select>

                <button
                    class="bg-red-800 hover:bg-red-700 text-white rounded-xl font-semibold">

                    Apply Filter

                </button>

            </form>

        </div>

        {{-- TABLE --}}
        <div class="glass rounded-2xl p-6 text-white">

            <div class="flex justify-between items-center mb-6">

                <div>
                    <h3 class="text-lg font-semibold">
                        All Borrow Requests
                    </h3>

                    <p class="text-white/50 text-sm">
                        Complete history of borrow requests
                    </p>
                </div>

                <a href="/admin/borrow-requests"
                   class="btn-close">
                    ✕
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
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($borrows as $borrow)

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

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center py-10 text-white/40">

                                No records found.

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