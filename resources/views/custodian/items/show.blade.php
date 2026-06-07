<x-app-layout>

<x-slot name="header">
    <div class="glass-header">
        <h2 class="text-2xl font-bold text-white">
            Item Details
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

    main {
        background: transparent !important;
    }

    nav, header {
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    .glass-wrapper {
        background: linear-gradient(to bottom right, rgba(80,0,0,0.35), rgba(0,0,0,0.25));
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(20px);
    }

    .glass-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.10);
        backdrop-filter: blur(14px);
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-2px);
        background: rgba(255,255,255,0.09);
    }

    .glass-label {
        color: rgba(255,255,255,0.65);
        font-size: 0.85rem;
    }

    .glass-text {
        color: white;
    }

    .status-badge {
        padding: 8px 14px;
        border-radius: 9999px;
        font-weight: 700;
        display: inline-block;
    }

    .status-low {
        background: rgba(255, 200, 0, 0.15);
        color: #facc15;
        border: 1px solid rgba(250, 204, 21, 0.3);
    }

    .status-unavailable {
        background: rgba(255, 0, 0, 0.15);
        color: #f87171;
        border: 1px solid rgba(248, 113, 113, 0.3);
    }

    .status-available {
        background: rgba(0, 255, 0, 0.10);
        color: #4ade80;
        border: 1px solid rgba(74, 222, 128, 0.3);
    }

    .glass-box {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.10);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        padding: 14px;
        color: rgba(255,255,255,0.85);
    }
</style>

<div class="min-h-screen py-12">

    <div class="max-w-4xl mx-auto px-4">

        <!-- MAIN WRAPPER -->
        <div class="glass-wrapper rounded-2xl p-8 text-white shadow-2xl">

            <!-- HEADER -->
            <div class="flex items-center justify-between mb-6">

                <h2 class="text-xl font-bold tracking-wide">
                    Item Details
                </h2>

                <a href="/custodian/inventory"
                   class="text-white/60 hover:text-red-300 transition text-sm">
                    ← Back
                </a>

            </div>

            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- ITEM NAME -->
                <div class="glass-card p-5 rounded-xl">
                    <p class="glass-label mb-1">Item Name</p>
                    <p class="glass-text text-lg font-semibold">
                        {{ $item->item_name }}
                    </p>
                </div>

                <!-- CATEGORY -->
                <div class="glass-card p-5 rounded-xl">
                    <p class="glass-label mb-1">Category</p>
                    <p class="glass-text text-lg font-semibold">
                        {{ $item->category }}
                    </p>
                </div>

                <!-- BRAND -->
                <div class="glass-card p-5 rounded-xl">
                    <p class="glass-label mb-1">Brand Name</p>
                    <p class="glass-text text-lg font-semibold">
                        {{ $item->brand_name }}
                    </p>
                </div>

                <!-- QUANTITY -->
                <div class="glass-card p-5 rounded-xl">
                    <p class="glass-label mb-1">Quantity</p>
                    <p class="glass-text text-lg font-semibold">
                        {{ $item->quantity }}
                    </p>
                </div>

                <!-- STATUS -->
                <div class="glass-card p-5 rounded-xl md:col-span-2">
                    <p class="glass-label mb-2">Status</p>

                    @if($item->quantity <= 0)
                        <span class="status-badge status-unavailable">
                            Unavailable
                        </span>

                    @elseif($item->quantity <= 5)
                        <span class="status-badge status-low">
                            Low Stock
                        </span>

                    @else
                        <span class="status-badge status-available">
                            Available
                        </span>
                    @endif

                </div>

            </div>

            <!-- DESCRIPTION -->
            <div class="mt-6 glass-card p-5 rounded-xl">

                <p class="glass-label mb-2">Description</p>

                <div class="glass-box">
                    {{ $item->description ?? 'No description available.' }}
                </div>

            </div>

        </div>

    </div>

</div>

</x-app-layout>