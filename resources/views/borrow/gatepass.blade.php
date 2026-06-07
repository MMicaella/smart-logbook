<x-app-layout>

    <div class="min-h-screen flex items-center justify-center py-10 px-4 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">

        <div class="w-full max-w-3xl">

            {{-- GLASS CARD --}}
            <div class="backdrop-blur-xl bg-white/10 border border-white/20 shadow-2xl rounded-3xl p-8 text-white">

                {{-- HEADER --}}
                <h2 class="text-3xl font-bold text-center mb-8 tracking-wide">
                    🎫 Gate Pass
                </h2>

                {{-- BORROW INFO --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                    <div class="bg-white/10 p-4 rounded-xl border border-white/10">
                        <p class="text-gray-300">Reference</p>
                        <p class="font-semibold text-white">{{ $borrow->reference_number }}</p>
                    </div>

                    <div class="bg-white/10 p-4 rounded-xl border border-white/10">
                        <p class="text-gray-300">Borrower</p>
                        <p class="font-semibold text-white">{{ $borrow->user->name }}</p>
                    </div>

                    <div class="bg-white/10 p-4 rounded-xl border border-white/10">
                        <p class="text-gray-300">Department</p>
                        <p class="font-semibold text-white">{{ $borrow->user->department ?? 'N/A' }}</p>
                    </div>

                    <div class="bg-white/10 p-4 rounded-xl border border-white/10">
                        <p class="text-gray-300">Item</p>
                        <p class="font-semibold text-white">{{ $borrow->item->item_name ?? 'Unknown Item' }}</p>
                    </div>

                    <div class="bg-white/10 p-4 rounded-xl border border-white/10">
                        <p class="text-gray-300">Quantity</p>
                        <p class="font-semibold text-white">{{ $borrow->quantity }}</p>
                    </div>

                    <div class="bg-white/10 p-4 rounded-xl border border-white/10 flex items-center justify-between">
                        <p class="text-gray-300">Status</p>
                        <span class="px-3 py-1 rounded-full text-xs font-bold
                            {{ $borrow->status === 'approved' ? 'bg-green-500/30 text-green-300' : 'bg-yellow-500/30 text-yellow-200' }}">
                            {{ ucfirst($borrow->status) }}
                        </span>
                    </div>

                </div>

                {{-- QR CODE --}}
                <div class="mt-10 text-center">

                    <h3 class="text-lg font-semibold mb-4 text-gray-200">
                        QR Code
                    </h3>

                    @if($borrow->qr_code)

                        <div class="inline-block p-4 rounded-2xl bg-white/10 border border-white/20 shadow-lg">
                            <img src="data:image/png;base64,{{ $borrow->qr_code }}"
                                 class="w-44 h-44 mx-auto">
                        </div>

                    @else

                        <p class="text-gray-400">No QR code available</p>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>