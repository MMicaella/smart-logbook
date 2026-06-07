<x-app-layout>

<style>
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

    header,
    nav,
    main {
        background: transparent !important;
        box-shadow: none !important;
    }

    .glass-card {
        background: rgba(255,255,255,0.10);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.35);
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
        color: rgba(255,255,255,.5);
    }

    select.glass-input option {
        background: #1a0000;
        color: white;
    }

    table {
        color: white !important;
        width: 100%;
    }

    th {
        color: rgba(255,255,255,.9);
    }

    td {
        color: rgba(255,255,255,.85);
    }

    tr:hover {
        background: rgba(255,255,255,.05);
    }

    .qr-btn {
        display: inline-flex;
        align-items: center;
        padding: 10px 16px;
        border-radius: 12px;
        background: rgba(59,130,246,.15);
        color: #bfdbfe;
        border: 1px solid rgba(96,165,250,.30);
        text-decoration: none;
        transition: .2s;
    }

    .qr-btn:hover {
        background: rgba(59,130,246,.25);
    }
</style>

<div class="max-w-7xl mx-auto py-10 px-4">

    <h2 class="text-2xl font-bold mb-6 text-white">
        My Borrow Requests
    </h2>

    {{-- FILTER CARD --}}
    <div class="glass-card p-5 mb-6">

        <form method="GET"
              action="{{ url()->current() }}"
              class="grid grid-cols-1 md:grid-cols-4 gap-3">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search reference or item..."
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

                <option value="returned"
                    {{ request('status') == 'returned' ? 'selected' : '' }}>
                    Returned
                </option>

            </select>

            <button
                class="bg-red-800 hover:bg-red-700 text-white rounded-xl font-semibold">

                Apply Filter

            </button>

        </form>

    </div>

    {{-- TABLE --}}
    <div class="glass-card overflow-hidden">

        <table class="text-sm text-left">

            <thead class="bg-white/10 text-white uppercase text-xs">

                <tr>
                    <th class="px-6 py-4">Reference</th>
                    <th class="px-6 py-4">Item</th>
                    <th class="px-6 py-4">Qty</th>
                    <th class="px-6 py-4">Location</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Gatepass QR</th>
                </tr>

            </thead>

            <tbody class="divide-y divide-white/10">

                @forelse($borrows as $borrow)

                    <tr>

                        <td class="px-6 py-4 font-semibold">
                            {{ $borrow->reference_number }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $borrow->item->item_name ?? 'Unknown Item' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $borrow->quantity }}
                        </td>

                        <td class="px-6 py-4">
                            {{ ucfirst($borrow->borrow_location ?? '-') }}
                        </td>

                        <td class="px-6 py-4">

                            @if($borrow->return_status == 'released')

                                <span class="text-blue-300">
                                    Released
                                </span>

                            @elseif($borrow->return_status == 'returned')

                                <span class="text-green-400">
                                    Returned
                                </span>

                            @elseif($borrow->status == 'approved')

                                <span class="text-green-400">
                                    Approved
                                </span>

                            @elseif($borrow->status == 'pending')

                                <span class="text-yellow-400">
                                    Pending
                                </span>

                            @elseif($borrow->status == 'rejected')

                                <span class="text-red-400">
                                    Rejected
                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4 text-center">

                            @if(
                                $borrow->borrow_location === 'outside'
                                && $borrow->return_status === 'released'
                            )

                                <a href="{{ route('borrow.qr', $borrow->id) }}"
                                   class="qr-btn">

                                    View Gatepass QR

                                </a>

                            @else

                                <span class="text-white/40 text-xs">
                                    N/A
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6"
                            class="text-center py-10 text-white/60">

                            No borrow requests found.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</x-app-layout>