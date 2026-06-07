<x-app-layout>

    <x-slot name="header">
        <div class="glass-card">
            <h2 class="text-3xl font-bold text-white">
                Borrow Archive
            </h2>

            <p class="text-white/60 mt-2">
                Archived borrow request records
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

        .glass {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(26px);
        }

        .glass-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(20px);
            padding: 20px;
            border-radius: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 14px;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.65);
            text-transform: uppercase;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        td {
            padding: 14px;
            color: rgba(255,255,255,0.88);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        tr:hover {
            background: rgba(255,255,255,0.03);
        }

        .close-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.25);
            color: #f87171;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transition: .2s;
            text-decoration: none;
        }

        .close-btn:hover {
            transform: scale(1.05);
        }
    </style>

    <div class="py-10">

        <div class="max-w-7xl mx-auto px-4">

            <div class="glass rounded-2xl p-6">

                <div class="flex justify-between items-center mb-6">

                    <div>

                        <h3 class="text-white text-xl font-semibold">
                            Archived Borrow Requests
                        </h3>

                        <p class="text-white/50 text-sm">
                            Historical borrowing records
                        </p>

                    </div>

                    <a href="/archive" class="close-btn">
                        ✕
                    </a>

                </div>

                <div class="overflow-x-auto">

                    <table>

                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>User</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Archived Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($borrows as $borrow)

                                <tr>

                                    <td>
                                        {{ $borrow->reference_number }}
                                    </td>

                                    <td>
                                        {{ $borrow->user->name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $borrow->item->item_name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $borrow->quantity }}
                                    </td>

                                    <td>
                                        {{ ucfirst($borrow->status) }}
                                    </td>

                                    <td>
                                        {{ $borrow->updated_at->format('M d, Y h:i A') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6"
                                        class="text-center py-10 text-white/40">

                                        No archived borrow requests found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>