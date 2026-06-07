<x-app-layout>

<x-slot name="header">
    <div class="glass-header">
        <h2 class="text-2xl font-bold text-white">
            User Management
        </h2>
    </div>
</x-slot>

<style>
    body {
        background:
            linear-gradient(rgba(25,0,0,0.75), rgba(10,0,0,0.85)),
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

    /* FULL TRANSPARENT LAYER */
    .glass-wrapper {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
    }

    /* TABLE */
    .glass-table {
        width: 100%;
        border-collapse: collapse;
    }

    .glass-table th {
        text-align: left;
        padding: 14px;
        font-size: 0.85rem;
        color: rgba(255,255,255,0.6);
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .glass-table td {
        padding: 14px;
        color: rgba(255,255,255,0.9);
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .glass-table tr {
        transition: 0.2s ease;
    }

    .glass-table tr:hover {
        background: rgba(255,255,255,0.03);
    }

    /* BUTTONS */
    .btn {
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: 0.2s;
        border: 1px solid transparent;
        backdrop-filter: blur(10px);
    }

    .btn-approve {
        background: rgba(34,197,94,0.10);
        color: #4ade80;
        border: 1px solid rgba(74,222,128,0.25);
    }

    .btn-approve:hover {
        background: rgba(34,197,94,0.18);
    }

    .btn-reject {
        background: rgba(239,68,68,0.10);
        color: #f87171;
        border: 1px solid rgba(248,113,113,0.25);
    }

    .btn-reject:hover {
        background: rgba(239,68,68,0.18);
    }

    /* BADGES */
    .badge {
        padding: 6px 12px;
        border-radius: 9999px;
        font-size: 0.8rem;
        font-weight: 700;
        display: inline-block;
        backdrop-filter: blur(8px);
    }

    .badge-approved {
        background: rgba(34,197,94,0.12);
        color: #4ade80;
        border: 1px solid rgba(74,222,128,0.25);
    }

    .badge-rejected {
        background: rgba(239,68,68,0.12);
        color: #f87171;
        border: 1px solid rgba(248,113,113,0.25);
    }

    .badge-pending {
        background: rgba(234,179,8,0.12);
        color: #facc15;
        border: 1px solid rgba(250,204,21,0.25);
    }
</style>

<div class="min-h-screen py-12">

    <div class="max-w-7xl mx-auto px-4">

        <!-- TRANSPARENT CONTAINER -->
        <div class="glass-wrapper rounded-2xl p-6 text-white shadow-2xl">

            <div class="mb-6">
                <h2 class="text-xl font-bold tracking-wide">
                    User Management
                </h2>
                <p class="text-white/50 text-sm">
                    Manage user approvals and access control
                </p>
            </div>

            <div class="overflow-x-auto">

                <table class="glass-table">

                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($users as $user)

                        <tr>

                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>

                            <td>
                                @if($user->status == 'pending')
                                    <span class="badge badge-pending">Pending</span>

                                @elseif($user->status == 'approved')
                                    <span class="badge badge-approved">Approved</span>

                                @elseif($user->status == 'rejected')
                                    <span class="badge badge-rejected">Rejected</span>
                                @endif
                            </td>

                            <td>
                                @if($user->status == 'pending')

                                    <div class="flex gap-2">

                                        <form action="/admin/users/{{ $user->id }}/approve" method="POST">
                                            @csrf
                                            <button class="btn btn-approve">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="/admin/users/{{ $user->id }}/reject" method="POST">
                                            @csrf
                                            <button class="btn btn-reject">
                                                Reject
                                            </button>
                                        </form>

                                    </div>

                                @else
                                    <span class="text-white/40 text-sm">
                                        No action available
                                    </span>
                                @endif
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</x-app-layout>