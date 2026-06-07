<x-app-layout>

<x-slot name="header">
    <div class="glass-header">
        <h2 class="text-2xl font-bold text-white">
            Drivers
        </h2>
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

    main {
        background: transparent !important;
    }

    nav, header {
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    /* WRAPPER */
    .glass-wrapper {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(25px);
    }

    /* TABLE TRANSPARENT STYLE */
    table {
        width: 100%;
        border-collapse: collapse;
        background: transparent;
    }

    thead {
        background: rgba(255,255,255,0.04);
    }

    th {
        text-align: left;
        padding: 14px;
        font-size: 0.75rem;
        color: rgba(255,255,255,0.7);
        border-bottom: 1px solid rgba(255,255,255,0.08);
        text-transform: uppercase;
    }

    td {
        padding: 14px;
        color: rgba(255,255,255,0.9);
        border-bottom: 1px solid rgba(255,255,255,0.05);
        background: transparent;
    }

    tbody tr {
        transition: 0.2s ease;
    }

    tbody tr:hover {
        background: rgba(255,255,255,0.03);
    }

    /* BUTTONS */
    .btn {
        padding: 8px 14px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: 0.2s;
        cursor: pointer;
        border: 1px solid transparent;
    }

    .btn-danger {
        background: rgba(239,68,68,0.15);
        color: #f87171;
        border: 1px solid rgba(248,113,113,0.3);
    }

    .btn-danger:hover {
        background: rgba(239,68,68,0.25);
    }

    .btn-primary {
        background: linear-gradient(to right, #7f1d1d, #991b1b);
        color: white;
        padding: 10px 16px;
        border-radius: 14px;
        font-weight: 600;
    }

    .btn-primary:hover {
        transform: scale(1.03);
    }

    .glass-wrapper {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(25px);
    }
</style>

<div class="min-h-screen py-12">

    <div class="max-w-6xl mx-auto px-4">

        <div class="glass-wrapper rounded-2xl p-6 text-white shadow-2xl">

            <!-- HEADER -->
            <div class="flex justify-between items-center mb-6">

                <h2 class="text-xl font-bold tracking-wide">
                    Drivers
                </h2>

                <a href="/admin/drivers/create"
                   class="btn btn-primary">
                    + Add Driver
                </a>

            </div>

            <!-- SUCCESS -->
            @if(session('success'))
                <div class="mb-4 bg-green-500/20 border border-green-400/30 text-green-200 p-4 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <!-- TABLE -->
            <div class="overflow-x-auto">

                <table>

                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>License</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($drivers as $driver)

                        <tr>

                            <td class="font-semibold">
                                {{ $driver->name }}
                            </td>

                            <td>
                                {{ $driver->license_number }}
                            </td>

                            <td>
                                {{ $driver->contact_number }}
                            </td>

                            <td>
                                <span class="text-white/80">
                                    {{ ucfirst($driver->status) }}
                                </span>
                            </td>

                            <td>
                                <form method="POST"
                                      action="/admin/drivers/{{ $driver->id }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger"
                                            onclick="return confirm('Delete driver?')">
                                        Delete
                                    </button>

                                </form>
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="5" class="text-center py-10 text-white/50">
                                No drivers added yet.
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