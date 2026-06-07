<x-app-layout>

<style>
    body {
        background:
            linear-gradient(rgba(25,0,0,0.80), rgba(10,0,0,0.92)),
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

    .glass-wrapper {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
    }

    .glass-muted {
        color: rgba(255,255,255,0.55);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        text-align: left;
        padding: 14px;
        font-size: .75rem;
        color: rgba(255,255,255,0.55);
        border-bottom: 1px solid rgba(255,255,255,0.08);
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    td {
        padding: 14px;
        color: rgba(255,255,255,0.92);
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    tr {
        transition: .2s ease;
    }

    tr:hover {
        background: rgba(255,255,255,0.03);
    }

    .status-approved {
        background: rgba(34,197,94,0.12);
        color: #86efac;
        border: 1px solid rgba(74,222,128,0.25);
        padding: 6px 12px;
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 600;
        display: inline-block;
    }

    .btn-release {
        background: rgba(59,130,246,0.10);
        color: #93c5fd;
        border: 1px solid rgba(96,165,250,0.25);
        padding: 8px 14px;
        border-radius: 12px;
        font-weight: 600;
        transition: .2s;
        backdrop-filter: blur(10px);
    }

    .btn-release:hover {
        background: rgba(59,130,246,0.18);
    }

    .success-alert {
        background: rgba(34,197,94,0.10);
        border: 1px solid rgba(74,222,128,0.25);
        color: #86efac;
        padding: 14px;
        border-radius: 14px;
        margin-bottom: 20px;
        backdrop-filter: blur(20px);
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: rgba(255,255,255,0.45);
    }
</style>

<div class="min-h-screen py-12">

    <div class="max-w-7xl mx-auto px-4">

        <!-- PAGE HEADER -->
        <div class="mb-6">

            <h2 class="text-3xl font-bold text-white">
                Request Item Release
            </h2>

            <p class="glass-muted mt-2">
                Approved requests waiting for item release
            </p>

        </div>

        <!-- SUCCESS MESSAGE -->
        @if(session('success'))

            <div class="success-alert">
                {{ session('success') }}
            </div>

        @endif

        <!-- MAIN PANEL -->
        <div class="glass-wrapper rounded-3xl p-6 shadow-2xl">

            <div class="overflow-x-auto">

                <table>

                    <thead>

                        <tr>
                            <th>Reference</th>
                            <th>Requester</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Location</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($requests as $request)

                        <tr>

                            <td>
                                {{ $request->reference_number }}
                            </td>

                            <td>
                                {{ $request->user->name }}
                            </td>

                            <td>
                                {{ $request->item->item_name }}
                            </td>

                            <td>
                                {{ $request->quantity }}
                            </td>

                            <td>
                                {{ $request->request_location }}
                            </td>

                            <td>
                                {{ $request->purpose }}
                            </td>

                            <td>

                                <span class="status-approved">
                                    Approved
                                </span>

                            </td>

                            <td>

                                <form method="POST"
                                      action="/custodian/request-release/{{ $request->id }}">

                                    @csrf

                                    <button class="btn-release">
                                        Release Item
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8">

                                <div class="empty-state">

                                    <div class="text-5xl mb-3">
                                        📦
                                    </div>

                                    <p class="text-lg">
                                        No approved requests found
                                    </p>

                                </div>

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