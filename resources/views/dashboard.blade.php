<x-app-layout>

    <x-slot name="header">
        <div class="glass-card">
            <h2 class="text-3xl font-bold text-white">
                Smart LogBook Dashboard
            </h2>

            <p class="glass-muted mt-2">
                Campus Management Overview
            </p>
        </div>
    </x-slot>

    @php
        $role = auth()->user()->role;
    @endphp

    <style>
        header {
            background: transparent !important;
            box-shadow: none !important;
        }

        body {
            background:
                linear-gradient(rgba(20,0,0,0.88), rgba(0,0,0,0.92)),
                url('/images/osmena-logo.png');

            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);

            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 22px;

            padding: 22px;

            box-shadow: 0 8px 30px rgba(0,0,0,0.30);

            transition: 0.25s ease;
        }

        .glass-card:hover {
            transform: translateY(-4px);
        }

        .glass-muted {
            color: rgba(255,255,255,0.70);
        }

        canvas {
            width: 100% !important;
            height: 100% !important;
        }
    </style>

    <div class="py-10 px-4">

        <div class="max-w-7xl mx-auto">

            {{-- TOTALS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="glass-card">
                    <p class="glass-muted text-sm">
                        Total Requests
                    </p>

                    <h2 class="text-4xl font-bold text-yellow-200 mt-3">
                        {{ $pending + $approved + $rejected }}
                    </h2>
                </div>

                <div class="glass-card">
                    <p class="glass-muted text-sm">
                        Total Bookings
                    </p>

                    <h2 class="text-4xl font-bold text-green-200 mt-3">
                        {{ $released + $returned }}
                    </h2>
                </div>

                <div class="glass-card">
                    <p class="glass-muted text-sm">
                        Total Borrows
                    </p>

                    <h2 class="text-4xl font-bold text-cyan-200 mt-3">
                        {{ $totalBorrows }}
                    </h2>
                </div>

            </div>

            {{-- ROLE BASED STATUS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

                {{-- ADMIN --}}
                @if($role === 'admin')

                    <div class="glass-card">
                        <p class="glass-muted text-sm">Pending</p>

                        <h2 class="text-4xl font-bold text-yellow-200 mt-3">
                            {{ $pending }}
                        </h2>
                    </div>

                    <div class="glass-card">
                        <p class="glass-muted text-sm">Approved</p>

                        <h2 class="text-4xl font-bold text-green-200 mt-3">
                            {{ $approved }}
                        </h2>
                    </div>

                    <div class="glass-card">
                        <p class="glass-muted text-sm">Rejected</p>

                        <h2 class="text-4xl font-bold text-red-200 mt-3">
                            {{ $rejected }}
                        </h2>
                    </div>

                @endif


                {{-- CUSTODIAN --}}
                @if($role === 'custodian')

                    <div class="glass-card">
                        <p class="glass-muted text-sm">Released</p>

                        <h2 class="text-4xl font-bold text-blue-200 mt-3">
                            {{ $released }}
                        </h2>
                    </div>

                    <div class="glass-card">
                        <p class="glass-muted text-sm">Returned</p>

                        <h2 class="text-4xl font-bold text-purple-200 mt-3">
                            {{ $returned }}
                        </h2>
                    </div>

                    <div class="glass-card">
                        <p class="glass-muted text-sm">Overdue</p>

                        <h2 class="text-4xl font-bold text-orange-200 mt-3">
                            {{ $overdue }}
                        </h2>
                    </div>

                @endif


                {{-- USER --}}
                @if($role === 'user')

                    <div class="glass-card">
                        <p class="glass-muted text-sm">Pending</p>

                        <h2 class="text-4xl font-bold text-yellow-200 mt-3">
                            {{ $pending }}
                        </h2>
                    </div>

                    <div class="glass-card">
                        <p class="glass-muted text-sm">Approved</p>

                        <h2 class="text-4xl font-bold text-green-200 mt-3">
                            {{ $approved }}
                        </h2>
                    </div>

                    <div class="glass-card">
                        <p class="glass-muted text-sm">Released</p>

                        <h2 class="text-4xl font-bold text-blue-200 mt-3">
                            {{ $released }}
                        </h2>
                    </div>

                    <div class="glass-card">
                        <p class="glass-muted text-sm">Returned</p>

                        <h2 class="text-4xl font-bold text-purple-200 mt-3">
                            {{ $returned }}
                        </h2>
                    </div>

                    <div class="glass-card">
                        <p class="glass-muted text-sm">Rejected</p>

                        <h2 class="text-4xl font-bold text-red-200 mt-3">
                            {{ $rejected }}
                        </h2>
                    </div>

                    <div class="glass-card">
                        <p class="glass-muted text-sm">Overdue</p>

                        <h2 class="text-4xl font-bold text-orange-200 mt-3">
                            {{ $overdue }}
                        </h2>
                    </div>

                @endif

            </div>

            {{-- CHART --}}
            <div class="mt-10">

                <div class="glass-card">

                    <h3 class="text-2xl font-bold text-white mb-6">
                        Dashboard Analytics
                    </h3>

                    <div style="height: 380px;">
                        <canvas id="dashboardChart"></canvas>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        Chart.defaults.color = "white";

        let labels = [];
        let values = [];
        let colors = [];

        @if($role === 'admin')

            labels = ['Pending', 'Approved', 'Rejected'];

            values = [
                {{ $pending }},
                {{ $approved }},
                {{ $rejected }}
            ];

            colors = [
                '#fde047',
                '#4ade80',
                '#f87171'
            ];

        @elseif($role === 'custodian')

            labels = ['Released', 'Returned', 'Overdue'];

            values = [
                {{ $released }},
                {{ $returned }},
                {{ $overdue }}
            ];

            colors = [
                '#60a5fa',
                '#c084fc',
                '#fb923c'
            ];

        @elseif($role === 'user')

            labels = [
                'Pending',
                'Approved',
                'Released',
                'Returned',
                'Rejected',
                'Overdue'
            ];

            values = [
                {{ $pending }},
                {{ $approved }},
                {{ $released }},
                {{ $returned }},
                {{ $rejected }},
                {{ $overdue }}
            ];

            colors = [
                '#fde047',
                '#4ade80',
                '#60a5fa',
                '#c084fc',
                '#f87171',
                '#fb923c'
            ];

        @endif

        new Chart(document.getElementById('dashboardChart'), {
            type: 'doughnut',

            data: {
                labels: labels,

                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderWidth: 0
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

</x-app-layout>