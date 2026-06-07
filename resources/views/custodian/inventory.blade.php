<x-app-layout>

<x-slot name="header">
    <div class="header-hover backdrop-blur-xl bg-white/10 border border-white/20 rounded-2xl px-6 py-4 shadow-lg transition duration-300">

        <h2 class="text-xl font-bold text-white tracking-wide">
            Smart Inventory Dashboard
        </h2>

        <p class="text-white/70 text-sm mt-1">
            Overview of inventory status and stock monitoring
        </p>

    </div>
</x-slot>

<style>
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

/* REMOVE BREEZE HEADER */
header {
    background: transparent !important;
    box-shadow: none !important;
}
.header-hover {
    transition: all 0.3s ease-in-out;
}

.header-hover:hover {
    transform: translateY(-3px) scale(1.01);
    box-shadow: 0 25px 50px rgba(0,0,0,0.45);
    background: rgba(255,255,255,0.18) !important;
    border-color: rgba(255,255,255,0.35);
}

/* GLOBAL HOVER SMOOTHING */
.hover-card {
    transition: all 0.25s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-5px) scale(1.01);
    box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    background: rgba(255,255,255,0.15) !important;
}

.table-row {
    transition: all 0.2s ease-in-out;
}

.table-row:hover {
    background: rgba(255,255,255,0.08);
    transform: scale(1.002);
}
</style>

<div class="py-10">

<div class="max-w-7xl mx-auto space-y-6">

    <!-- TOP DASHBOARD -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT SIDE -->
        <div class="lg:col-span-1 flex flex-col gap-4">

            <!-- TOTAL ITEMS -->
            <div class="hover-card backdrop-blur-xl bg-white/10 border border-white/20 p-6 rounded-2xl shadow-lg text-white">

                <h4 class="text-white/70 text-sm mb-2">Total Items</h4>

                <div class="flex items-center justify-between">

                    <h2 class="text-3xl font-bold text-white">
                        {{ $totalItems }}
                    </h2>

                    <div class="bg-blue-500/20 text-blue-200 px-3 py-1 rounded-full text-sm border border-blue-400/30">
                        Inventory
                    </div>

                </div>

            </div>

            <!-- SYSTEM STATUS -->
            <div class="hover-card backdrop-blur-xl bg-white/10 border border-white/20 p-6 rounded-2xl shadow-lg text-white">

                <h4 class="text-white/70 text-sm mb-2">System Status</h4>

                <div class="flex items-center justify-between">

                    <h2 class="text-2xl font-bold text-green-300">
                        Active
                    </h2>

                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>

                </div>

            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="lg:col-span-2 hover-card backdrop-blur-xl bg-white/10 border border-white/20 p-6 rounded-2xl shadow-lg text-white">

            <div class="flex items-center justify-between mb-5">

                <h2 class="text-xl font-bold text-red-300">
                    Low Stock Items
                </h2>

                <span class="bg-red-500/20 text-red-200 px-3 py-1 rounded-full text-sm border border-red-400/30">
                    {{ $lowStock }}
                </span>

            </div>

            @php
                $lowStockItems = $items->where('quantity', '<=', 5);
            @endphp

            <div class="space-y-3">

                @forelse($lowStockItems as $low)

                    <a href="/custodian/items/{{ $low->id }}"
                       class="hover-card block border border-white/10 rounded-xl p-4 hover:bg-red-500/10 transition duration-300">

                        <div class="flex justify-between items-center">

                            <div>

                                <h3 class="font-semibold text-white text-lg">
                                    {{ $low->item_name }}
                                </h3>

                                <p class="text-sm text-white/60">
                                    {{ $low->brand_name }}
                                </p>

                                <p class="text-xs text-white/40 font-mono">
                                    {{ $low->serial_number }}
                                </p>

                            </div>

                            <div class="text-right">

                                <p class="text-red-300 text-xl font-bold">
                                    {{ $low->quantity }}
                                </p>

                                <p class="text-xs text-white/40">
                                    Remaining
                                </p>

                            </div>

                        </div>

                    </a>

                @empty

                    <div class="text-center text-white/50 py-10">
                        No low stock items.
                    </div>

                @endforelse

            </div>

        </div>

    </div>

    <!-- ALL ITEMS -->
    <div class="hover-card backdrop-blur-xl bg-white/10 border border-white/20 p-6 rounded-2xl shadow-lg text-white">

        <div class="mb-4 flex justify-between items-center">

            <h2 class="text-lg font-bold">
                {{ auth()->user()->department }} Department Items
            </h2>

            <div class="flex gap-3">

                <button onclick="toggleBorrowedModal()"
                        class="hover-card bg-purple-500/30 hover:bg-purple-500/50 text-white px-4 py-2 rounded-xl border border-purple-400/30">

                    Most Borrowed

                </button>

                <a href="/custodian/items/create"
                   class="hover-card bg-blue-500/30 hover:bg-blue-500/50 text-white px-4 py-2 rounded-xl border border-blue-400/30">

                    + Add Item

                </a>

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-white">

                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-left p-4">Item</th>
                        <th class="text-left p-4">Category</th>
                        <th class="text-left p-4">Qty</th>
                        <th class="text-left p-4">Department</th>
                        <th class="text-left p-4">Status</th>
                        <th class="text-left p-4">Action</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($items as $item)

                    <tr class="table-row border-b border-white/10">

                        <td class="p-4">
                            <a href="/custodian/items/{{ $item->id }}">
                                <h3 class="text-blue-300 font-semibold hover:text-blue-200 transition">
                                    {{ $item->item_name }}
                                </h3>
                                <p class="text-white/60 text-sm">
                                    {{ $item->brand_name ?? '-' }}
                                </p>
                            </a>
                        </td>

                        <td class="p-4 text-white/70">{{ $item->category }}</td>
                        <td class="p-4 font-semibold">{{ $item->quantity }}</td>
                        <td class="p-4 text-white/70">{{ $item->department }}</td>

                        <td class="p-4">

                            @if($item->quantity <= 0)
                                <span class="text-red-200 bg-red-500/20 px-3 py-1 rounded-full border border-red-400/30">
                                    Unavailable
                                </span>

                            @elseif($item->quantity <= 5)
                                <span class="text-yellow-200 bg-yellow-500/20 px-3 py-1 rounded-full border border-yellow-400/30">
                                    Low Stock
                                </span>

                            @else
                                <span class="text-green-200 bg-green-500/20 px-3 py-1 rounded-full border border-green-400/30">
                                    Available
                                </span>
                            @endif

                        </td>

                        <td class="p-4 flex gap-2">

                            <a href="/custodian/items/{{ $item->id }}/edit"
                               class="hover-card bg-yellow-500/30 px-3 py-2 rounded-lg border border-yellow-400/30">

                                Edit
                            </a>

                            <form action="/custodian/items/{{ $item->id }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="hover-card bg-red-500/30 px-3 py-2 rounded-lg border border-red-400/30">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

</x-app-layout>