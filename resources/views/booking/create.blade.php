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

    /* INPUT STYLE */
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

    /* BUTTON */
    .glass-button {
        width: 100%;
        background: rgba(59,130,246,0.25);
        border: 1px solid rgba(96,165,250,0.4);
        color: white;
        padding: 14px;
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
                Vehicle Booking
            </h2>

            <p class="text-white/60 mt-2">
                Fill in the required booking details below.
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

        <form method="POST" action="/booking">
            @csrf

            <!-- DOUBLE COLUMN GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- VEHICLE --}}
                <div>

                    <label class="block mb-2">
                        Vehicle
                    </label>

                    <select name="vehicle_id"
                            class="glass-input"
                            required>

                        <option value="">
                            Choose vehicle
                        </option>

                        @foreach($vehicles as $vehicle)

                            <option value="{{ $vehicle->id }}">

                                {{ $vehicle->name }}
                                ({{ $vehicle->plate_number }})

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- DRIVER --}}
                <div>

                    <label class="block mb-2">
                        Driver
                    </label>

                    <select name="driver_id"
                            class="glass-input"
                            required>

                        <option value="">
                            Choose driver
                        </option>

                        @foreach($drivers as $driver)

                            <option value="{{ $driver->id }}">

                                {{ $driver->name }}
                                - {{ $driver->license_number }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- DATE --}}
                <div>

                    <label class="block mb-2">
                        Date
                    </label>

                    <input type="date"
                           name="date"
                           min="{{ date('Y-m-d') }}"
                           class="glass-input"
                           required>

                </div>

                {{-- TIME --}}
                <div>

                    <label class="block mb-2">
                        Time
                    </label>

                    <input type="time"
                           name="time"
                           class="glass-input"
                           required>

                </div>

                {{-- DESTINATION --}}
                <div class="md:col-span-2">

                    <label class="block mb-2">
                        Destination
                    </label>

                    <input type="text"
                           name="destination"
                           class="glass-input"
                           placeholder="Enter destination"
                           required>

                </div>

                {{-- PURPOSE --}}
                <div class="md:col-span-2">

                    <label class="block mb-2">
                        Purpose
                    </label>

                    <textarea name="purpose"
                              class="glass-input"
                              placeholder="Enter purpose"
                              required></textarea>

                </div>

            </div>

            {{-- SUBMIT --}}
            <div class="mt-8">

                <button type="submit"
                        class="glass-button">

                    Submit Booking

                </button>

            </div>

        </form>

    </div>

</div>

</x-app-layout>