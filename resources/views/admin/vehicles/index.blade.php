<x-app-layout>

<style>
    body {
        background:
            linear-gradient(rgba(25,0,0,0.78), rgba(10,0,0,0.92)),
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

    /* TRUE GLASS WRAPPER */
    .glass-wrapper {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(28px);
        -webkit-backdrop-filter: blur(28px);
    }

    /* TABLE */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        text-align: left;
        padding: 14px;
        font-size: 0.72rem;
        color: rgba(255,255,255,0.55);
        border-bottom: 1px solid rgba(255,255,255,0.08);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    td {
        padding: 14px;
        color: rgba(255,255,255,0.9);
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    tr {
        transition: 0.2s ease;
    }

    tr:hover {
        background: rgba(255,255,255,0.03);
        transform: scale(1.001);
    }

    /* BUTTONS */
    .btn {
        padding: 8px 14px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: 0.2s;
        border: 1px solid transparent;
        cursor: pointer;
        backdrop-filter: blur(10px);
    }

    .btn-danger {
        background: rgba(239,68,68,0.10);
        color: #f87171;
        border: 1px solid rgba(248,113,113,0.25);
    }

    .btn-danger:hover {
        background: rgba(239,68,68,0.18);
    }

    .btn-primary {
        background: rgba(59,130,246,0.10);
        color: #60a5fa;
        border: 1px solid rgba(96,165,250,0.25);
    }

    .btn-primary:hover {
        background: rgba(59,130,246,0.18);
    }

    .btn-dark {
        background: rgba(255,255,255,0.06);
        color: rgba(255,255,255,0.85);
        border: 1px solid rgba(255,255,255,0.12);
    }

    .btn-dark:hover {
        background: rgba(255,255,255,0.10);
    }

    /* SELECT */
    select {
        background: rgba(255,255,255,0.06) !important;
        border: 1px solid rgba(255,255,255,0.12) !important;
        color: white !important;
        padding: 8px 10px;
        border-radius: 12px;
        outline: none;
        backdrop-filter: blur(10px);
    }

    select option {
        background: #1a0000;
        color: white;
    }

    /* SUCCESS / ERROR */
    .alert {
        padding: 12px 14px;
        border-radius: 14px;
        margin-bottom: 14px;
        backdrop-filter: blur(20px);
    }

    .alert-success {
        background: rgba(34,197,94,0.10);
        border: 1px solid rgba(74,222,128,0.25);
        color: #86efac;
    }

    .alert-error {
        background: rgba(239,68,68,0.10);
        border: 1px solid rgba(248,113,113,0.25);
        color: #fca5a5;
    }
</style>

<div class="min-h-screen py-12">

    <div class="max-w-6xl mx-auto px-4">

        <!-- GLASS PANEL -->
        <div class="glass-wrapper rounded-2xl p-6 text-white shadow-2xl">

            <!-- HEADER -->
            <div class="flex justify-between items-center mb-6">

                <h2 class="text-xl font-bold">
                    Vehicles
                </h2>

                <div class="flex gap-3">

                    <a href="/admin/drivers" class="btn btn-dark">
                        View Drivers
                    </a>

                    <a href="/admin/vehicles/create" class="btn btn-primary">
                        + Add Vehicle
                    </a>

                </div>

            </div>

            <!-- ALERTS -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <!-- TABLE -->
            <div class="overflow-x-auto">

                <table>

                    <thead>
                        <tr>
                            <th>Vehicle</th>
                            <th>Plate Number</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($vehicles as $vehicle)

                        <tr>

                            <td class="font-semibold">
                                {{ $vehicle->name }}
                            </td>

                            <td>{{ $vehicle->plate_number }}</td>

                            <td>{{ $vehicle->type }}</td>

                            <td>
                                <form method="POST"
                                      action="/admin/vehicles/{{ $vehicle->id }}/status">
                                    @csrf

                                    <select name="status"
                                            onchange="this.form.submit()">

                                        <option value="available"
                                            {{ $vehicle->status == 'available' ? 'selected' : '' }}>
                                            Available
                                        </option>

                                        <option value="maintenance"
                                            {{ $vehicle->status == 'maintenance' ? 'selected' : '' }}>
                                            Maintenance
                                        </option>

                                        <option value="unavailable"
                                            {{ $vehicle->status == 'unavailable' ? 'selected' : '' }}>
                                            Unavailable
                                        </option>

                                    </select>

                                </form>
                            </td>

                            <td>
                                <form method="POST"
                                      action="/admin/vehicles/{{ $vehicle->id }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger"
                                            onclick="return confirm('Delete this vehicle?')">
                                        Delete
                                    </button>

                                </form>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-10 text-white/40">
                                No vehicles added yet.
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