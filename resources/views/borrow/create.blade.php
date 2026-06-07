<x-app-layout>

<style>
    /* ===============================
       🔥 GLOBAL DARK GLASS UI
    =============================== */

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

    header {
        background: transparent !important;
        box-shadow: none !important;
    }

    /* GLASS CARD */
    .glass-card {
        background: rgba(255, 255, 255, 0.10);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 24px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.35);
    }

    /* INPUTS */
    .glass-input {
        width: 100%;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.15);
        color: white;
        padding: 14px;
        border-radius: 14px;
        outline: none;
        transition: 0.3s;
    }

    .glass-input:focus {
        border-color: rgba(255,255,255,0.4);
        box-shadow: 0 0 0 3px rgba(255,255,255,0.08);
    }

    .glass-input option {
        color: black;
    }

    textarea.glass-input {
        min-height: 140px;
        resize: none;
    }

    label {
        color: white;
        font-weight: 600;
    }

    .glass-muted {
        color: rgba(255,255,255,0.65);
    }

    /* BUTTON */
    .glass-button {
        width: 100%;
        background: rgba(59,130,246,0.25);
        border: 1px solid rgba(96,165,250,0.4);
        color: white;
        padding: 14px 24px;
        border-radius: 14px;
        font-weight: 600;
        transition: 0.3s;
    }

    .glass-button:hover {
        background: rgba(59,130,246,0.40);
        transform: translateY(-1px);
    }

    /* ALERTS */
    .success-alert {
        background: rgba(34,197,94,0.18);
        border: 1px solid rgba(74,222,128,0.3);
        color: rgb(187,247,208);
    }

    .error-alert {
        background: rgba(239,68,68,0.18);
        border: 1px solid rgba(248,113,113,0.3);
        color: rgb(254,202,202);
    }
</style>

<div class="max-w-5xl mx-auto py-10 px-4">

    <div class="glass-card p-8">

        <!-- HEADER -->
        <div class="mb-8">

            <h2 class="text-3xl font-bold text-white">
                Borrow Request Form
            </h2>

            <p class="text-white/60 mt-2">
                Fill in the borrowing details below.
            </p>

        </div>

        {{-- ERROR --}}
        @if(session('error'))
            <div class="error-alert p-4 rounded-xl mb-5">
                {{ session('error') }}
            </div>
        @endif

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="success-alert p-4 rounded-xl mb-5">
                {{ session('success') }}
            </div>
        @endif

        <!-- FILTER FORM -->
        <form method="GET" action="/borrow">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- DEPARTMENT -->
                <div>

                    <label class="block mb-2">
                        Select Department
                    </label>

                    <select name="department"
                            onchange="this.form.submit()"
                            class="glass-input">

                        <option value="">
                            Select Department
                        </option>

                        @foreach($departments as $dept)

                            <option value="{{ $dept }}"
                                {{ request('department') == $dept ? 'selected' : '' }}>

                                {{ $dept }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- CATEGORY -->
                @if(request('department'))

                <div>

                    <label class="block mb-2">
                        Select Category
                    </label>

                    <select name="category"
                            onchange="this.form.submit()"
                            class="glass-input">

                        <option value="">
                            Select Category
                        </option>

                        @foreach($categories as $category)

                            <option value="{{ $category }}"
                                {{ request('category') == $category ? 'selected' : '' }}>

                                {{ $category }}

                            </option>

                        @endforeach

                    </select>

                </div>

                @endif

            </div>

        </form>

        {{-- SHOW BORROW FORM --}}
        @if(request('department') && request('category'))

        <form action="/borrow"
              method="POST"
              class="mt-8">

            @csrf

            <input type="hidden"
                   name="department"
                   value="{{ request('department') }}">

            <!-- DOUBLE COLUMN GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- ITEM -->
                <div>

                    <label class="block mb-2">
                        Select Item
                    </label>

                    <select name="item_id"
                            id="itemSelect"
                            class="glass-input"
                            required>

                        <option value="">
                            Choose Item
                        </option>

                        @foreach($items as $item)

                            <option value="{{ $item->id }}"
                                    data-qty="{{ $item->quantity }}">

                                {{ $item->item_name }}
                                (Available: {{ $item->quantity }})

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- QUANTITY -->
                <div>

                    <label class="block mb-2">
                        Quantity
                    </label>

                    <input type="number"
                           name="quantity"
                           id="quantityInput"
                           min="1"
                           class="glass-input"
                           required>

                    <p class="glass-muted text-sm mt-2">
                        Available Quantity:
                        <span id="availableQty">0</span>
                    </p>

                </div>
                
                <div>
    <label class="block mb-2">
        Borrow Location
    </label>

    <select name="borrow_location"
            class="glass-input"
            required>

        <option value="inside">
            Inside Campus
        </option>

        <option value="outside">
            Outside Campus
        </option>

    </select>
</div>
                <!-- PURPOSE -->
                <div class="md:col-span-2">

                    <label class="block mb-2">
                        Purpose
                    </label>

                    <textarea name="purpose"
                              class="glass-input"
                              required></textarea>

                </div>
            </div>

            <!-- SUBMIT -->
            <div class="mt-8">

                <button class="glass-button">

                    Submit Request

                </button>

            </div>

        </form>

        @endif

    </div>

</div>

<script>

const itemSelect = document.getElementById('itemSelect');
const availableQty = document.getElementById('availableQty');
const quantityInput = document.getElementById('quantityInput');

if(itemSelect){

    itemSelect.addEventListener('change', function(){

        let selected = this.options[this.selectedIndex];
        let qty = selected.getAttribute('data-qty') || 0;

        availableQty.innerText = qty;

        quantityInput.max = qty;
    });

}

function sendOtp(){

    let button = document.getElementById('otpBtn');

    button.disabled = true;
    button.innerText = 'Sending...';

    fetch('/send-otp', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            type: 'borrow'
        })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || 'OTP sent');
    })
    .catch(err => {
        console.log(err);
        alert('Error sending OTP');
    })
    .finally(() => {
        button.disabled = false;
        button.innerText = 'Send OTP';
    });
}

</script>

</x-app-layout>