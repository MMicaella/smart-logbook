<x-app-layout>

<x-slot name="header"></x-slot>

<style>
    html,
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        overflow-x: hidden;
    }

    body{
        background:
            linear-gradient(rgba(20,0,0,0.78), rgba(0,0,0,0.88)),
            url('{{ asset('images/osmena-logo.png') }}');

        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
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

    input::placeholder,
    textarea::placeholder{
        color: rgba(255,255,255,0.35);
    }
</style>

<div class="min-h-screen py-10">

    <div class="max-w-5xl mx-auto px-4">

        <!-- MAIN CARD -->
        <div class="glass-card rounded-3xl shadow-2xl p-8 text-white relative">

            <!-- CLOSE BUTTON -->
            <a href="/custodian/inventory"
               class="absolute top-5 right-6 text-white/60 hover:text-red-400 text-3xl font-bold transition duration-300 hover:rotate-90">
                &times;
            </a>

            <!-- TITLE -->
            <div class="mb-10">

                <h2 class="text-4xl font-bold tracking-wide">
                    Add New Item
                </h2>

                <p class="text-white/60 mt-2">
                    Fill in the item information below.
                </p>

            </div>

            <form action="/custodian/items" method="POST">
                @csrf

                @php
                    $inputStyle = "
                        w-full
                        bg-white/10
                        border border-white/15
                        text-white
                        p-3
                        rounded-xl
                        focus:ring-2
                        focus:ring-red-500
                        focus:outline-none
                        transition-all
                        duration-300
                    ";

                    $cardStyle = "
                        glass-inner
                        smooth-hover
                        p-5
                        rounded-2xl
                    ";
                @endphp

                <!-- TOP GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- ITEM NAME -->
                    <div class="{{ $cardStyle }}">

                        <label class="block text-sm uppercase tracking-wider text-white/60 mb-3">
                            Item Name
                        </label>

                        <input type="text"
                               name="item_name"
                               placeholder="Enter item name"
                               class="{{ $inputStyle }}"
                               required>

                    </div>

                    <!-- CATEGORY -->
                    <div class="{{ $cardStyle }}">

                        <label class="block text-sm uppercase tracking-wider text-white/60 mb-3">
                            Category
                        </label>

                        <input type="text"
                               name="category"
                               placeholder="Enter category"
                               class="{{ $inputStyle }}"
                               required>

                    </div>

                    <!-- BRAND -->
                    <div class="{{ $cardStyle }}">

                        <label class="block text-sm uppercase tracking-wider text-white/60 mb-3">
                            Brand Name
                        </label>

                        <input type="text"
                               name="brand_name"
                               placeholder="Enter brand name"
                               class="{{ $inputStyle }}"
                               required>

                    </div>

                    <!-- QUANTITY -->
                    <div class="{{ $cardStyle }}">

                        <label class="block text-sm uppercase tracking-wider text-white/60 mb-3">
                            Number of Units
                        </label>

                        <input type="number"
                               id="quantity"
                               name="quantity"
                               min="1"
                               placeholder="Enter quantity"
                               class="{{ $inputStyle }}"
                               required>

                    </div>

                </div>

                <!-- SERIAL NUMBERS -->
                <div class="{{ $cardStyle }} mt-6">

                    <label class="block text-sm uppercase tracking-wider text-white/60 mb-4">
                        Serial Numbers
                    </label>

                    <!-- SERIAL GRID -->
                    <div id="serialContainer"
                         class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    </div>

                </div>

                <!-- DESCRIPTION -->
                <div class="{{ $cardStyle }} mt-6">

                    <label class="block text-sm uppercase tracking-wider text-white/60 mb-3">
                        Description
                    </label>

                    <textarea name="description"
                              rows="5"
                              placeholder="Enter item description..."
                              class="{{ $inputStyle }}"></textarea>

                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="w-full mt-8 bg-red-600/90 hover:bg-red-700 text-white py-4 rounded-2xl font-semibold text-lg transition-all duration-300 hover:scale-[1.01] shadow-xl"
                >
                    Save Item
                </button>

            </form>

        </div>

    </div>

</div>

</x-app-layout>

<script>
document.getElementById('quantity').addEventListener('input', function () {

    let qty = parseInt(this.value);
    let container = document.getElementById('serialContainer');

    container.innerHTML = '';

    if (qty > 0) {

        for (let i = 1; i <= qty; i++) {

            container.innerHTML += `
                <div class="glass-inner smooth-hover p-4 rounded-2xl">

                    <label class="block text-sm uppercase tracking-wider text-white/60 mb-3">
                        Serial Number ${i}
                    </label>

                    <input type="text"
                           name="serial_numbers[]"
                           placeholder="Enter serial number"
                           class="
                               w-full
                               bg-white/10
                               border border-white/15
                               text-white
                               placeholder-white/30
                               p-3
                               rounded-xl
                               focus:ring-2
                               focus:ring-red-500
                               focus:outline-none
                               transition-all
                               duration-300
                           "
                           required>

                </div>
            `;
        }
    }
});
</script>