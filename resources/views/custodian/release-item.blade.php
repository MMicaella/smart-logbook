<x-app-layout>

<x-slot name="header">
    <h2 class="text-xl font-bold text-white">
        Release Item
    </h2>
</x-slot>

<style>
    html,
    body {
        margin: 0;
        padding: 0;
        background: #1a0000 !important;
    }

    body {
        overflow-x: hidden;

        background:
            linear-gradient(rgba(25,0,0,0.82), rgba(0,0,0,0.90)),
            url('{{ asset('images/osmena-logo.png') }}');

        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;

        min-height: 100vh;
    }

    main {
        background: transparent !important;
        padding: 0 !important;
    }

    nav {
        background: rgba(255,255,255,0.05) !important;
        backdrop-filter: blur(14px);
        border: none !important;
        box-shadow: none !important;
    }

    header {
        display: none !important;
    }
</style>

<div class="min-h-screen py-10 bg-gradient-to-br from-[#3b0000]/80 via-[#2a0000]/80 to-[#1a0000]/90">

    <div class="max-w-4xl mx-auto px-4">

        <!-- MAIN CARD -->
        <div class="backdrop-blur-xl bg-white/10 border border-white/10 shadow-2xl rounded-3xl p-8 text-white">

            <!-- TITLE -->
            <div class="mb-8">

                <h2 class="text-3xl font-bold tracking-wide">
                    Release Item
                </h2>

                <p class="text-white/60 mt-2">
                    Verify and release the requested item.
                </p>

            </div>

            @php
                $cardStyle = "p-5 rounded-2xl border border-white/10 bg-white/5 backdrop-blur-md transition-all duration-300 hover:bg-white/10 hover:scale-[1.01] hover:shadow-xl";

                $inputStyle = "w-full bg-white/10 border border-white/20 text-white placeholder-white/40 p-3 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:outline-none transition-all duration-300 hover:bg-white/15";

                $serials = [];

                if (!empty($borrow->item->serial_number)) {
                    $serials = explode(',', $borrow->item->serial_number);
                }
            @endphp

            <!-- REQUEST DETAILS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">

                <!-- ITEM -->
                <div class="{{ $cardStyle }}">

                    <p class="text-xs text-white/60 mb-2">
                        Item
                    </p>

                    <p class="font-semibold text-lg">
                        {{ $borrow->item->item_name }}
                    </p>

                </div>

                <!-- REQUESTED BY -->
                <div class="{{ $cardStyle }}">

                    <p class="text-xs text-white/60 mb-2">
                        Requested By
                    </p>

                    <p class="font-semibold text-lg">
                        {{ $borrow->user->name }}
                    </p>

                </div>

                <!-- QUANTITY -->
                <div class="{{ $cardStyle }}">

                    <p class="text-xs text-white/60 mb-2">
                        Quantity
                    </p>

                    <p class="font-semibold text-lg">
                        {{ $borrow->quantity }}
                    </p>

                </div>

                <!-- DATE -->
                <div class="{{ $cardStyle }}">

                    <p class="text-xs text-white/60 mb-2">
                        Date Requested
                    </p>

                    <p class="font-semibold text-lg">
                        {{ $borrow->created_at->format('M d, Y') }}
                    </p>

                </div>

            </div>

            <!-- FORM -->
            <form method="POST"
                  action="/custodian/borrowings/{{ $borrow->id }}/release">

                @csrf
                @method('PUT')

                <!-- BRAND -->
                <div class="{{ $cardStyle }} mb-5">

                    <label class="block text-sm font-medium text-white/80 mb-3">
                        Brand Name
                    </label>

                    <input type="text"
                           name="brand_name"
                           value="{{ $borrow->item->brand_name }}"
                           class="{{ $inputStyle }}"
                           required>

                </div>

                <!-- SERIAL NUMBERS -->
                <div class="{{ $cardStyle }} mb-5">

                    <label class="block text-sm font-medium text-white/80 mb-4">
                        Select Serial Numbers
                    </label>

                    <div id="serial-container"
                         class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        @for($i = 0; $i < $borrow->quantity; $i++)

                            <div>

                                <label class="block text-xs text-white/60 mb-2">
                                    Serial Number {{ $i + 1 }}
                                </label>

                                <select name="serial_numbers[]"
                                        class="serial-select {{ $inputStyle }}"
                                        required>

                                    <option value="">
                                        Select Serial Number
                                    </option>

                                    @foreach($serials as $serial)

                                        <option value="{{ trim($serial) }}">
                                            {{ trim($serial) }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        @endfor

                    </div>

                    @error('serial_numbers')

                        <p class="text-red-400 text-sm mt-3">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

                <!-- REMARKS -->
                <div class="{{ $cardStyle }} mb-6">

                    <label class="block text-sm font-medium text-white/80 mb-3">
                        Item Condition / Remarks
                    </label>

                    <textarea name="remarks"
                              rows="4"
                              placeholder="Example: Good condition, complete accessories..."
                              class="{{ $inputStyle }}"></textarea>

                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 hover:scale-[1.02] text-white py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg shadow-green-900/40"
                >
                    Confirm Release
                </button>

            </form>

        </div>

    </div>

</div>

<!-- DUPLICATE SERIAL PREVENTION -->
<script>

document.addEventListener('DOMContentLoaded', function () {

    const selects = document.querySelectorAll('.serial-select');

    selects.forEach(select => {

        select.addEventListener('change', updateOptions);

    });

    function updateOptions() {

        let selectedValues = [];

        selects.forEach(select => {

            if (select.value !== '') {

                selectedValues.push(select.value);

            }

        });

        selects.forEach(currentSelect => {

            const currentValue = currentSelect.value;

            Array.from(currentSelect.options).forEach(option => {

                if (
                    option.value !== '' &&
                    option.value !== currentValue &&
                    selectedValues.includes(option.value)
                ) {

                    option.disabled = true;

                } else {

                    option.disabled = false;

                }

            });

        });

    }

});

</script>

</x-app-layout>