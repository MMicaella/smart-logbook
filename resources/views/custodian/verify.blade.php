<x-app-layout>

    <x-slot name="header">
        <div class="glass-card">
            <h2 class="text-2xl font-bold text-white">
                Verify Borrow Reference
            </h2>
            <p class="text-white/70 text-sm mt-1">
                Enter the reference number to validate a borrow request
            </p>
        </div>
    </x-slot>

    <style>
        /* ===============================
           REMOVE BREEZE WHITE HEADER
        =============================== */

        header,
        header.bg-white,
        .bg-white.shadow,
        .bg-white {
            background: transparent !important;
            box-shadow: none !important;
        }

        /* kill default header padding container */
        .py-6,
        .max-w-7xl,
        .mx-auto,
        .sm\\:px-6,
        .lg\\:px-8 {
            background: transparent !important;
        }

        /* ===============================
           GLASS UI FIX (MATCH DASHBOARD)
        =============================== */

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

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 20px;
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 18px;
            color: white;
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: white;
            padding: 12px;
            border-radius: 10px;
            width: 100%;
            outline: none;
        }

        .glass-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .glass-btn {
            background: linear-gradient(135deg, #7f1d1d, #991b1b);
            color: white;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            transition: 0.2s ease;
        }

        .glass-btn:hover {
            transform: scale(1.02);
            opacity: 0.95;
        }
    </style>

    <div class="py-10">

        <div class="max-w-xl mx-auto px-4">

            <div class="glass-box p-8 shadow-2xl">

                <h2 class="text-xl font-bold mb-4 text-white">
                    Enter Reference Number
                </h2>

                <p class="text-white/60 text-sm mb-6">
                    Please input the borrow reference code provided by the system.
                </p>

                @if(session('error'))
                    <div class="bg-red-500/20 border border-red-400 text-red-100 p-3 mb-4 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="/custodian/verify" class="space-y-4">
                    @csrf

                    <input
                        type="text"
                        name="reference"
                        placeholder="e.g. BR-2026-0001"
                        class="glass-input"
                        required
                    >

                    <button class="glass-btn">
                        Verify Reference
                    </button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>