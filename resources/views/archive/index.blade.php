<x-app-layout>

    <x-slot name="header">
        <div class="glass-card">
            <h2 class="text-3xl font-bold text-white">
                Archive Center
            </h2>

            <p class="glass-muted mt-2">
                View archived borrow requests, bookings, and item requests
            </p>
        </div>
    </x-slot>

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

        main,
        nav,
        header {
            background: transparent !important;
            box-shadow: none !important;
        }

        .glass-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(24px);
            border-radius: 24px;
        }

        .glass-muted {
            color: rgba(255,255,255,0.65);
        }

        .archive-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(24px);
            border-radius: 24px;
            transition: .3s ease;
            display: block;
            text-decoration: none;
        }

        .archive-card:hover {
            transform: translateY(-6px);
            border-color: rgba(255,255,255,0.18);
            box-shadow: 0 20px 50px rgba(0,0,0,0.35);
        }

        .archive-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .archive-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
        }

        .archive-desc {
            color: rgba(255,255,255,0.6);
            margin-top: 8px;
            font-size: .9rem;
        }
    </style>

    <div class="min-h-screen py-10">

        <div class="max-w-7xl mx-auto px-4">

            <div class="glass-card p-6 mb-8">

                <h3 class="text-white text-xl font-semibold">
                    Archive Dashboard
                </h3>

                <p class="glass-muted mt-2">
                    Access archived records from completed and historical transactions.
                </p>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- BORROWS --}}
                <a href="/archive/borrows"
                   class="archive-card p-8">

                    <div class="archive-icon">
                        📦
                    </div>

                    <div class="archive-title">
                        Borrow Archive
                    </div>

                    <div class="archive-desc">
                        View completed and archived borrow transactions.
                    </div>

                </a>

                {{-- BOOKINGS --}}
                <a href="/archive/bookings"
                   class="archive-card p-8">

                    <div class="archive-icon">
                        🚗
                    </div>

                    <div class="archive-title">
                        Booking Archive
                    </div>

                    <div class="archive-desc">
                        View archived vehicle booking records.
                    </div>

                </a>

                {{-- REQUESTS --}}
                <a href="/archive/requests"
                   class="archive-card p-8">

                    <div class="archive-icon">
                        📋
                    </div>

                    <div class="archive-title">
                        Request Archive
                    </div>

                    <div class="archive-desc">
                        View archived item request records.
                    </div>

                </a>

            </div>

        </div>

    </div>

</x-app-layout>