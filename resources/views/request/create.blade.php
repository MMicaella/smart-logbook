<x-app-layout>

<style>
    body {
        background:
            linear-gradient(rgba(30,0,0,0.82), rgba(0,0,0,0.88)),
            url('/images/osmena-logo.png');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
    }

    main,
    nav,
    header {
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    .glass-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
    }

    .glass-input {
        width: 100%;
        padding: 14px;
        border-radius: 14px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        color: white;
        outline: none;
        transition: .2s;
    }

    .glass-input:focus {
        border-color: rgba(96,165,250,0.5);
        box-shadow: 0 0 0 3px rgba(96,165,250,0.15);
    }

    .glass-input option {
        background: #1a0000;
        color: white;
    }

    label {
        color: rgba(255,255,255,.85);
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }

    .glass-button {
        width: 100%;
        padding: 14px;
        border-radius: 14px;
        font-weight: 600;
        color: white;
        background: rgba(59,130,246,0.15);
        border: 1px solid rgba(96,165,250,0.25);
        transition: .2s;
    }

    .glass-button:hover {
        background: rgba(59,130,246,0.25);
    }

    .success-alert {
        background: rgba(34,197,94,0.12);
        border: 1px solid rgba(74,222,128,0.25);
        color: #86efac;
    }

    .error-alert {
        background: rgba(239,68,68,0.12);
        border: 1px solid rgba(248,113,113,0.25);
        color: #fca5a5;
    }

    .otp-alert {
        background: rgba(250,204,21,0.10);
        border: 1px solid rgba(250,204,21,0.20);
        color: #fde68a;
    }
</style>

<div class="max-w-6xl mx-auto py-12 px-4">

    <div class="glass-card rounded-3xl p-8 shadow-2xl">

        <div class="mb-8">

            <h2 class="text-3xl font-bold text-white">
                Request Item Form
            </h2>

            <p class="text-white/60 mt-2">
                Submit your item request information below.
            </p>

        </div>

        @if(session('success'))
            <div class="success-alert p-4 rounded-xl mb-5">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="error-alert p-4 rounded-xl mb-5">
                {{ session('error') }}
            </div>
        @endif

        <!-- FILTER -->
        <form method="GET" action="/request-item">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label>Select Department</label>

                    <select name="department"
                            onchange="this.form.submit()"
                            class="glass-input">

                        <option value="">Select Department</option>

                        @foreach($departments as $department)
                            <option value="{{ $department }}"
                                {{ request('department') == $department ? 'selected' : '' }}>
                                {{ $department }}
                            </option>
                        @endforeach

                    </select>
                </div>

                @if(request('department'))
                <div>

                    <label>Select Category</label>

                    <select name="category"
                            onchange="this.form.submit()"
                            class="glass-input">

                        <option value="">Select Category</option>

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

        @if(request('department') && request('category'))

        <form method="POST"
              action="/request-item/store"
              class="mt-8">

            @csrf

            <input type="hidden"
                   name="department"
                   value="{{ request('department') }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label>Select Item</label>

                    <select name="item_id"
                            class="glass-input"
                            required>

                        <option value="">Select Item</option>

                        @foreach($items as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->item_name }} ({{ $item->quantity }})
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label>Quantity</label>

                    <input type="number"
                           name="quantity"
                           class="glass-input"
                           required>
                </div>

                <div>
                    <label>Source of Fund</label>

                    <input type="text"
                           name="fund_source"
                           class="glass-input"
                           required>
                </div>

                <div>
                    <label>Request Location</label>

                    <select name="request_location"
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

                <div class="md:col-span-2">

                    <label>Purpose</label>

                    <textarea name="purpose"
                              class="glass-input"
                              rows="5"
                              required></textarea>

                </div>

            </div>

            <div class="otp-alert rounded-2xl p-5 mt-6">

                <p class="font-bold mb-1">
                    OTP Required
                </p>

                <p class="text-sm text-white/70">
                    After submitting, you will be redirected to the OTP verification page.
                </p>

            </div>

            <div class="mt-8">

                <button class="glass-button">
                    Submit Request
                </button>

            </div>

        </form>

        @endif

    </div>

</div>

</x-app-layout>