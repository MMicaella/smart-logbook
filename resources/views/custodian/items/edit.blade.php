<x-app-layout>

{{-- <x-slot name="header">
    <div class="glass-header">
        <h2 class="text-2xl font-bold text-white">
            Update Item Quantity
        </h2>
    </div>
</x-slot> --}}

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
        background: linear-gradient(to bottom right, rgba(80,0,0,0.35), rgba(0,0,0,0.2));
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

    .glass-input {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.15);
        color: white;
        border-radius: 14px;
        padding: 12px;
        width: 100%;
        outline: none;
        transition: 0.3s;
    }

    .glass-input:focus {
        border-color: rgba(255,80,80,0.6);
        box-shadow: 0 0 0 3px rgba(255,0,0,0.15);
    }

    .glass-input:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>

<div class="min-h-screen py-12">

    <div class="max-w-4xl mx-auto px-4">

        <!-- MAIN CARD -->
        <div class="glass-wrapper rounded-2xl p-8 text-white shadow-2xl">

            <!-- HEADER ROW -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold tracking-wide">
                    Update Item Quantity
                </h2>

                <a href="/custodian/inventory"
                   class="text-white/60 hover:text-red-300 transition text-sm">
                    ← Back
                </a>
            </div>

            <!-- SUCCESS -->
            @if(session('success'))
                <div class="mb-5 bg-green-500/20 border border-green-400/30 text-green-200 p-4 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ERRORS -->
            @if ($errors->any())
                <div class="mb-5 bg-red-500/20 border border-red-400/30 text-red-200 p-4 rounded-xl">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/custodian/items/{{ $item->id }}" method="POST">
                @csrf
                @method('PUT')

                <!-- GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div class="glass-card p-5 rounded-xl">
                        <label class="text-sm text-white/60">Item Name</label>
                        <input type="text"
                               value="{{ $item->item_name }}"
                               class="glass-input mt-2"
                               disabled>
                    </div>

                    <div class="glass-card p-5 rounded-xl">
                        <label class="text-sm text-white/60">Category</label>
                        <input type="text"
                               value="{{ $item->category }}"
                               class="glass-input mt-2"
                               disabled>
                    </div>

                    <div class="glass-card p-5 rounded-xl">
                        <label class="text-sm text-white/60">Current Quantity</label>
                        <input type="number"
                               value="{{ $item->quantity }}"
                               class="glass-input mt-2"
                               disabled>
                    </div>

                    <div class="glass-card p-5 rounded-xl">
                        <label class="text-sm text-white/60">New Quantity</label>
                        <input type="number"
                               name="quantity"
                               value="{{ old('quantity', $item->quantity) }}"
                               min="0"
                               class="glass-input mt-2"
                               required>
                    </div>

                </div>

                <!-- BUTTON -->
                <button type="submit"
                        class="mt-6 w-full py-3 rounded-xl font-semibold text-white
                               bg-gradient-to-r from-blue-700 to-blue-900
                               hover:from-blue-600 hover:to-blue-800
                               shadow-lg transition transform hover:scale-[1.02]">
                    Update Quantity
                </button>

            </form>

        </div>

    </div>

</div>

</x-app-layout>