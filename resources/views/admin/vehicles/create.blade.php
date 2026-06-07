<x-app-layout>

<style>
    body {
        background:
            linear-gradient(rgba(25,0,0,0.85), rgba(10,0,0,0.95)),
            url('/images/osmena-logo.png');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
    }

    main, nav, header {
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    /* GLASS CONTAINER */
    .glass-wrapper {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
    }

    /* INPUT */
    .glass-input {
        width: 100%;
        padding: 12px;
        border-radius: 14px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        color: white;
        outline: none;
        transition: 0.2s;
    }

    .glass-input:focus {
        border-color: rgba(255,80,80,0.6);
        box-shadow: 0 0 0 3px rgba(255,0,0,0.15);
    }

    /* LABEL */
    .glass-label {
        color: rgba(255,255,255,0.7);
        font-size: 0.85rem;
        margin-bottom: 6px;
        display: block;
    }

    /* BUTTON */
    .btn-primary {
        background: linear-gradient(to right, #7f1d1d, #991b1b);
        color: white;
        padding: 12px 18px;
        border-radius: 14px;
        font-weight: 600;
        transition: 0.2s;
        width: 100%;
    }

    .btn-primary:hover {
        transform: scale(1.02);
        background: linear-gradient(to right, #991b1b, #b91c1c);
    }

    /* ERROR */
    .error-box {
        background: rgba(239,68,68,0.12);
        border: 1px solid rgba(248,113,113,0.25);
        color: #fca5a5;
        padding: 14px;
        border-radius: 14px;
        margin-bottom: 16px;
    }
</style>

<div class="min-h-screen py-12">

    <div class="max-w-4xl mx-auto px-4">

        <div class="glass-wrapper rounded-2xl p-8 text-white shadow-2xl">

            <!-- TITLE -->
            <h2 class="text-2xl font-bold mb-2">
                Add Vehicle
            </h2>

            <p class="text-white/50 text-sm mb-6">
                Fill in the vehicle details below
            </p>

            <!-- ERRORS -->
            @if ($errors->any())
                <div class="error-box">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="/admin/vehicles/store">
                @csrf

                <!-- GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- VEHICLE NAME -->
                    <div>
                        <label class="glass-label">Vehicle Name</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="glass-input"
                               required>
                    </div>

                    <!-- PLATE NUMBER -->
                    <div>
                        <label class="glass-label">Plate Number</label>
                        <input type="text"
                               name="plate_number"
                               value="{{ old('plate_number') }}"
                               class="glass-input"
                               required>
                    </div>

                    <!-- TYPE -->
                    <div>
                        <label class="glass-label">Vehicle Type</label>
                        <input type="text"
                               name="type"
                               placeholder="Van / Car / Shuttle"
                               value="{{ old('type') }}"
                               class="glass-input"
                               required>
                    </div>

                    <!-- STATUS -->
                    <div>
                        <label class="glass-label">Status</label>
                        <select name="status" class="glass-input">
                            <option value="available">Available</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                    </div>

                </div>

                <!-- BUTTON -->
                <div class="mt-6">
                    <button class="btn-primary">
                        Add Vehicle
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

</x-app-layout>