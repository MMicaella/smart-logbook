<x-app-layout>

<style>

    /* ===============================
       🔥 GLOBAL GLASS UI
    =============================== */

    .min-h-screen.bg-gray-100{
        background: transparent !important;
    }

    body{

        background:
            linear-gradient(rgba(25,0,0,0.82), rgba(0,0,0,0.90)),
            url('{{ asset('images/osmena-logo.png') }}');

        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;

        min-height: 100vh;
    }

    header{
        background: transparent !important;
        box-shadow: none !important;
    }

    /* ===============================
       🔥 GLASS CARD
    =============================== */

    .glass-card{

        background: rgba(255,255,255,0.08);

        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);

        border: 1px solid rgba(255,255,255,0.12);

        border-radius: 28px;

        box-shadow:
            0 8px 32px rgba(0,0,0,0.35);
    }

    /* ===============================
       🔥 TABLE
    =============================== */

    table{
        color: white !important;
    }

    thead{
        background: rgba(255,255,255,0.08);
    }

    th{
        color: rgba(255,255,255,0.85);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    td{
        color: rgba(255,255,255,0.82);
    }

    tbody tr{
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    tbody tr:hover{
        background: rgba(255,255,255,0.05);
    }

    /* ===============================
       🔥 STATUS BADGES
    =============================== */

    .badge{

        padding: 8px 14px;

        border-radius: 999px;

        font-size: 0.75rem;
        font-weight: 700;

        display: inline-block;
    }

    .badge-blue{
        background: rgba(59,130,246,0.18);
        color: rgb(191,219,254);
        border: 1px solid rgba(96,165,250,0.25);
    }

    .badge-green{
        background: rgba(34,197,94,0.18);
        color: rgb(187,247,208);
        border: 1px solid rgba(74,222,128,0.25);
    }

    .badge-yellow{
        background: rgba(234,179,8,0.18);
        color: rgb(253,224,71);
        border: 1px solid rgba(250,204,21,0.25);
    }

    .badge-gray{
        background: rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.75);
        border: 1px solid rgba(255,255,255,0.12);
    }

    /* ===============================
       🔥 SERIAL NUMBERS
    =============================== */

    .serial-summary{

        cursor: pointer;

        background: rgba(255,255,255,0.08);

        border: 1px solid rgba(255,255,255,0.10);

        padding: 10px 14px;

        border-radius: 14px;

        font-size: 0.82rem;
        font-weight: 600;

        color: rgba(255,255,255,0.85);

        transition: 0.3s;
    }

    .serial-summary:hover{
        background: rgba(255,255,255,0.14);
    }

    .serial-box{

        background: rgba(255,255,255,0.06);

        border: 1px solid rgba(255,255,255,0.10);

        padding: 10px 14px;

        border-radius: 14px;

        font-size: 0.78rem;

        font-family: monospace;

        color: rgba(255,255,255,0.85);
    }

    /* ===============================
       🔥 BUTTONS
    =============================== */

    .glass-btn{

        padding: 10px 16px;

        border-radius: 14px;

        font-size: 0.82rem;
        font-weight: 600;

        color: white;

        text-align: center;

        transition: 0.3s;

        border: 1px solid transparent;
    }

    .glass-btn:hover{
        transform: translateY(-1px);
    }

    .btn-blue{
        background: rgba(59,130,246,0.22);
        border-color: rgba(96,165,250,0.25);
    }

    .btn-blue:hover{
        background: rgba(59,130,246,0.35);
    }

    .btn-green{
        background: rgba(34,197,94,0.22);
        border-color: rgba(74,222,128,0.25);
    }

    .btn-green:hover{
        background: rgba(34,197,94,0.35);
    }

    .completed-box{

        background: rgba(34,197,94,0.18);

        border: 1px solid rgba(74,222,128,0.25);

        color: rgb(187,247,208);

        padding: 10px 14px;

        border-radius: 14px;

        text-align: center;

        font-size: 0.82rem;
        font-weight: 700;
    }

    /* ===============================
       🔥 ALERT
    =============================== */

    .success-alert{

        background: rgba(34,197,94,0.18);

        border: 1px solid rgba(74,222,128,0.25);

        color: rgb(187,247,208);

        border-radius: 18px;
    }


/* ===============================
   🔥 HEADER HOVER EFFECT
=============================== */

.custodian-header{
    transition: all 0.3s ease;
    cursor: pointer;
}

.custodian-header:hover{
    transform: translateY(-4px);
    background: rgba(255,255,255,0.12);
    box-shadow: 0 15px 40px rgba(0,0,0,0.45);
    border: 1px solid rgba(255,255,255,0.25);
}


/* SEARCH INPUT */
.search-input{
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    color: #ffffff !important;
    padding: 12px 16px;
    border-radius: 14px;
    outline: none;
}

.search-input::placeholder{
    color: rgba(255,255,255,0.65);
}

/* SELECT */
.search-select{
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    color: #ffffff !important;
    padding: 12px 16px;
    border-radius: 14px;
    outline: none;
}

.search-select option{
    background: #1a0000;
    color: #ffffff;
}

/* SEARCH BUTTON */
.search-btn{
    background: rgba(59,130,246,0.25);
    border: 1px solid rgba(96,165,250,0.30);
    color: white;
    border-radius: 14px;
    font-weight: 700;
    transition: .3s;
}

.search-btn:hover{
    background: rgba(59,130,246,0.40);
}

/* PAGINATION */

nav[role="navigation"]{
    color:white !important;
}

nav[role="navigation"] span,
nav[role="navigation"] a{

    background: rgba(255,255,255,0.08) !important;

    border: 1px solid rgba(255,255,255,0.12) !important;

    color: white !important;

    border-radius: 12px !important;

    margin: 0 4px;
}

nav[role="navigation"] a:hover{
    background: rgba(255,255,255,0.18) !important;
}

nav[role="navigation"] span[aria-current="page"] span{

    background: rgba(59,130,246,0.35) !important;

    border-color: rgba(96,165,250,0.35) !important;

    color: white !important;
}
</style>

<x-slot name="header">

    {{-- <div class="glass-card p-6">

        <h2 class="text-3xl font-bold text-white">
            Custodian Borrow Requests
        </h2>

        <p class="text-white/60 mt-2">
            Manage released and returned borrowed items
        </p>

    </div> --}}
    <div class="glass-card p-6 custodian-header">

    <h2 class="text-3xl font-bold text-white">
        Custodian Borrow Requests
    </h2>

    <p class="text-white/60 mt-2">
        Manage released and returned borrowed items
    </p>

</div>

</x-slot>

<div class="py-10 px-4">

    <div class="max-w-7xl mx-auto">

        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="success-alert p-4 mb-6">

                {{ session('success') }}

            </div>

        @endif

        {{-- TABLE --}}
        <div class="glass-card overflow-hidden">

            <div class="glass-card p-6 mb-6">

    <form method="GET"
          action="{{ url()->current() }}"
          class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search reference, borrower, item..."
            class="search-input">

        <select
            name="status"
            class="search-select">

            <option value="">All Status</option>

            <option value="approved"
                {{ request('status') == 'approved' ? 'selected' : '' }}>
                Ready For Release
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

        <button type="submit"
                class="search-btn">
            Search
        </button>

    </form>

</div>
{{-- <p class="text-white">
    Total Records: {{ $borrows->total() }}
</p> --}}
{{-- TABLE CARD --}}
<div class="glass-card overflow-hidden">

    <div class="overflow-x-auto"></div>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>

                        <tr>

                            <th class="p-5 text-left">
                                Reference
                            </th>

                            {{-- <th class="p-5 text-left">
                                Borrower
                            </th> --}}

                            <th class="p-5 text-left">
                                Department
                            </th>


                            <th class="p-5 text-left">
                                Item
                            </th>

                            <th class="p-5 text-left">
                                Brand
                            </th>

                            <th class="p-5 text-left">
                                Quantity
                            </th>

                            <th class="p-5 text-left">
                                Serial Numbers
                            </th>

                            <th class="p-5 text-left">
                                Borrow Location
                            </th>

                            <th class="p-5 text-left">
                                Status
                            </th>

                            <th class="p-5 text-left">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($borrows as $borrow)

                        <tr class="align-top">

                            {{-- REFERENCE --}}
                            <td class="p-5 font-semibold">
                                {{ $borrow->reference_number }}
                            </td>

                            {{-- BORROWER --}}
                            <td class="p-5">
                                {{ $borrow->user->department }}
                            </td>

                            {{-- DEPARTMENT
                            <td class="p-5">
                                {{ $borrow->department }}
                            </td> --}}

                            {{-- ITEM --}}
                            <td class="p-5">
                                {{ $borrow->item->item_name }}
                            </td>

                            {{-- BRAND --}}
                            <td class="p-5">
                                {{ $borrow->brand_name ?? $borrow->item->brand_name ?? '-' }}
                            </td>

                            {{-- QUANTITY --}}
                            <td class="p-5 font-bold">
                                {{ $borrow->quantity }}
                            </td>

                            {{-- SERIAL --}}
                            <td class="p-5">

                                @php
                                    $serials = [];

                                    if($borrow->serial_number){
                                        $decoded = json_decode($borrow->serial_number, true);

                                        if(is_array($decoded)){
                                            $serials = $decoded;
                                        }
                                    }
                                @endphp

                                @if(count($serials))

                                    <details>

                                        <summary class="serial-summary">

                                            View Serial Numbers ({{ count($serials) }})

                                        </summary>

                                        <div class="mt-3 space-y-2">

                                            @foreach($serials as $serial)

                                                <div class="serial-box">

                                                    {{ $serial }}

                                                </div>

                                            @endforeach

                                        </div>

                                    </details>

                                @else

                                    <span class="text-white/40 text-sm">
                                        Not released yet
                                    </span>

                                @endif

                            </td>

                            <td class="p-5">
                            @if($borrow->borrow_location == 'inside')
                                <span class="badge badge-blue">
                                    Inside Campus
                                </span>
                            @else
                                <span class="badge badge-green">
                                    Outside Campus
                                </span>
                            @endif
                            </td>

                            {{-- STATUS --}}
                            <td class="p-5">

                                @if($borrow->return_status == 'released')

                                    <span class="badge badge-blue">
                                        Released
                                    </span>

                                @elseif($borrow->return_status == 'returned')

                                    <span class="badge badge-green">
                                        Returned
                                    </span>

                                @elseif($borrow->status == 'approved')

                                    <span class="badge badge-yellow">
                                        Ready for Release
                                    </span>

                                @else

                                    <span class="badge badge-gray">
                                        Pending
                                    </span>

                                @endif

                            </td>

                            {{-- ACTION --}}
                            <td class="p-5">

                                <div class="flex flex-col gap-3">

                                    {{-- RELEASE --}}
                                    @if($borrow->status == 'approved'
                                        && $borrow->return_status != 'released'
                                        && $borrow->return_status != 'returned')

                                        <a href="/custodian/borrowings/{{ $borrow->id }}/release"
                                           class="glass-btn btn-blue">

                                            Release

                                        </a>

                                    @endif

                                    {{-- RETURN --}}
                                    @if($borrow->return_status == 'released')

                                        <form method="POST"
                                              action="/custodian/return/{{ $borrow->id }}">

                                            @csrf

                                            <button class="glass-btn btn-green w-full">

                                                Mark Returned

                                            </button>

                                        </form>

                                    @endif

                                    {{-- DONE --}}
                                    @if($borrow->return_status == 'returned')

                                        <div class="completed-box">

                                            Completed

                                        </div>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="p-10 text-center text-white/50">

                                No approved requests yet.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

           <div class="p-6">
    <div class="flex justify-center gap-3 items-center text-white">

        {{-- PREVIOUS --}}
        @if ($borrows->onFirstPage())
            <span class="px-5 py-2 rounded-xl bg-white/5 text-white/30 border border-white/10 cursor-not-allowed">
                ← Previous
            </span>
        @else
            <a href="{{ $borrows->previousPageUrl() }}"
               class="px-5 py-2 rounded-xl bg-white/10 border border-white/20 hover:bg-white/20 transition">
                ← Previous
            </a>
        @endif

        {{-- PAGE INFO (optional subtle indicator) --}}
        <span class="text-white/40 text-sm">
            Page {{ $borrows->currentPage() }} of {{ $borrows->lastPage() }}
        </span>

        {{-- NEXT --}}
        @if ($borrows->hasMorePages())
            <a href="{{ $borrows->nextPageUrl() }}"
               class="px-5 py-2 rounded-xl bg-white/10 border border-white/20 hover:bg-white/20 transition">
                Next →
            </a>
        @else
            <span class="px-5 py-2 rounded-xl bg-white/5 text-white/30 border border-white/10 cursor-not-allowed">
                Next →
            </span>
        @endif

    </div>
</div>

        </div>

    </div>

</div>

</x-app-layout>