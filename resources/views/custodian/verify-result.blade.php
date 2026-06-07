<x-app-layout>

<x-slot name="header"></x-slot>

<style>
    html,
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    body{
        background:
            linear-gradient(rgba(20,0,0,0.78), rgba(0,0,0,0.88)),
            url('{{ asset('images/osmena-logo.png') }}');

        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;

        overflow-x: hidden;
    }

    main {
        background: transparent !important;
        padding: 0 !important;
    }

    nav {
        background: rgba(255,255,255,0.04) !important;
        backdrop-filter: blur(18px);
        border-bottom: 1px solid rgba(255,255,255,0.08);
        box-shadow: none !important;
    }

    header {
        display: none !important;
    }

    .glass-card{
        background: rgba(255,255,255,0.07);
        backdrop-filter: blur(18px);
        border: 1px solid rgba(255,255,255,0.08);
    }

    .glass-inner{
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.08);
    }

    .smooth-hover{
        transition: all 0.3s ease;
    }

    .smooth-hover:hover{
        transform: translateY(-2px);
        background: rgba(255,255,255,0.08);
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    }

    .serial-pill{
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.14);
    }
</style>

<div class="min-h-screen py-10">

    <div class="max-w-5xl mx-auto px-4">

        <!-- MAIN CARD -->
        <div class="glass-card rounded-3xl shadow-2xl p-8 text-white">

            <!-- TITLE -->
            <div class="flex items-center justify-between mb-10">

                <div>
                    <h2 class="text-4xl font-bold tracking-wide">
                        Borrow Record Details
                    </h2>

                    <p class="text-white/60 mt-2">
                        View released and returned borrowed item details
                    </p>
                </div>

                @if($borrow->status === 'approved')

                    <span class="bg-green-500/20 text-green-200 px-5 py-2 rounded-full text-sm font-semibold border border-green-400/30">
                        Approved Request
                    </span>

                @elseif($borrow->status === 'pending')

                    <span class="bg-yellow-500/20 text-yellow-200 px-5 py-2 rounded-full text-sm font-semibold border border-yellow-400/30">
                        Pending Approval
                    </span>

                @else

                    <span class="bg-red-500/20 text-red-200 px-5 py-2 rounded-full text-sm font-semibold border border-red-400/30">
                        Rejected Request
                    </span>

                @endif

            </div>

            @php
                $cardBase = "glass-inner smooth-hover p-6 rounded-2xl";

                $serials = [];

                if($borrow->serial_number){
                    $decoded = json_decode($borrow->serial_number, true);

                    if(is_array($decoded)){
                        $serials = $decoded;
                    }
                }
            @endphp

            <!-- DETAILS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Reference -->
                <div class="{{ $cardBase }}">
                    <p class="text-xs uppercase tracking-wider text-white/50 mb-2">
                        Reference Number
                    </p>

                    <p class="font-bold text-3xl">
                        {{ $borrow->reference_number }}
                    </p>
                </div>

                <!-- Borrower -->
                <div class="{{ $cardBase }}">
                    <p class="text-xs uppercase tracking-wider text-white/50 mb-2">
                        Borrower
                    </p>

                    <p class="font-bold text-2xl">
                        {{ $borrow->user->name ?? 'N/A' }}
                    </p>
                </div>

                <!-- Email -->
                <div class="{{ $cardBase }}">
                    <p class="text-xs uppercase tracking-wider text-white/50 mb-2">
                        Email
                    </p>

                    <p class="font-semibold text-lg break-all">
                        {{ $borrow->user->email ?? 'N/A' }}
                    </p>
                </div>

                <!-- Item -->
                <div class="{{ $cardBase }}">
                    <p class="text-xs uppercase tracking-wider text-white/50 mb-2">
                        Item
                    </p>

                    <p class="font-bold text-2xl">
                        {{ $borrow->item->item_name ?? 'N/A' }}
                    </p>
                </div>

                <!-- Brand -->
                <div class="{{ $cardBase }}">
                    <p class="text-xs uppercase tracking-wider text-white/50 mb-2">
                        Brand
                    </p>

                    <p class="font-bold text-2xl">
                        {{ $borrow->brand_name ?? $borrow->item->brand_name ?? '-' }}
                    </p>
                </div>

                <!-- Serial Numbers -->
                <div class="{{ $cardBase }}">

                    <p class="text-xs uppercase tracking-wider text-white/50 mb-3">
                        Serial Numbers
                    </p>

                    @if(count($serials))

                        <div class="flex flex-wrap gap-3">

                            @foreach($serials as $serial)

                                <span class="serial-pill px-4 py-2 rounded-xl text-sm font-semibold">
                                    {{ $serial }}
                                </span>

                            @endforeach

                        </div>

                    @else

                        <p class="text-white/50">
                            No serial numbers released yet.
                        </p>

                    @endif

                </div>

                <!-- Quantity -->
                <div class="{{ $cardBase }}">
                    <p class="text-xs uppercase tracking-wider text-white/50 mb-2">
                        Quantity
                    </p>

                    <p class="font-bold text-3xl">
                        {{ $borrow->quantity }}
                    </p>
                </div>

                <!-- STATUS -->
                <div class="{{ $cardBase }}">

                    <p class="text-xs uppercase tracking-wider text-white/50 mb-3">
                        Status
                    </p>

                    @if($borrow->return_status == 'released')

                        <span class="bg-blue-500/20 text-blue-200 px-4 py-2 rounded-full text-sm font-semibold border border-blue-400/30">
                            Released
                        </span>

                    @elseif($borrow->return_status == 'returned')

                        <span class="bg-green-500/20 text-green-200 px-4 py-2 rounded-full text-sm font-semibold border border-green-400/30">
                            Completed
                        </span>

                    @elseif($borrow->status == 'approved')

                        <span class="bg-yellow-500/20 text-yellow-200 px-4 py-2 rounded-full text-sm font-semibold border border-yellow-400/30">
                            Ready for Release
                        </span>

                    @else

                        <span class="bg-gray-500/20 text-gray-200 px-4 py-2 rounded-full text-sm font-semibold border border-gray-400/30">
                            Pending
                        </span>

                    @endif

                </div>

            </div>

            <!-- REMARKS -->
            @if($borrow->remarks)

                <div class="mt-8 {{ $cardBase }}">

                    <p class="text-xs uppercase tracking-wider text-white/50 mb-3">
                        Custodian Remarks
                    </p>

                    <p class="text-white/90 text-lg leading-relaxed">
                        {{ $borrow->remarks }}
                    </p>

                </div>

            @endif

            <!-- STATUS BOX -->
            <div class="mt-8">

                @if($borrow->return_status == 'released')

                    <div class="bg-blue-500/15 border border-blue-400/20 text-blue-200 px-6 py-5 rounded-2xl font-semibold backdrop-blur-md">
                        Item has been released to the borrower.
                    </div>

                @elseif($borrow->return_status == 'returned')

                    <div class="bg-green-500/15 border border-green-400/20 text-green-200 px-6 py-5 rounded-2xl font-semibold backdrop-blur-md">
                        Completed Transaction
                    </div>

                @elseif($borrow->status == 'approved')

                    <div class="bg-yellow-500/15 border border-yellow-400/20 text-yellow-200 px-6 py-5 rounded-2xl font-semibold backdrop-blur-md">
                        Ready for Release
                    </div>

                @else

                    <div class="bg-gray-500/15 border border-gray-400/20 text-gray-200 px-6 py-5 rounded-2xl font-semibold backdrop-blur-md">
                        Pending Approval
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

</x-app-layout>