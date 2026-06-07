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

    /* MAIN GLASS PANEL */
    .glass-wrapper {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(28px);
        -webkit-backdrop-filter: blur(28px);
    }

    /* NOTIFICATION CARD */
    .notif-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.06);
        transition: 0.2s ease;
        backdrop-filter: blur(12px);
    }

    .notif-card:hover {
        background: rgba(255,255,255,0.05);
        transform: translateY(-2px);
    }

    /* MUTED TEXT */
    .glass-muted {
        color: rgba(255,255,255,0.55);
    }

    /* BUTTON */
    .glass-btn {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.10);
        color: white;
        padding: 10px 16px;
        border-radius: 12px;
        font-weight: 600;
        transition: 0.2s;
        backdrop-filter: blur(10px);
    }

    .glass-btn:hover {
        background: rgba(255,255,255,0.12);
    }

    /* ICON */
    .notif-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: rgba(255,255,255,0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        border: 1px solid rgba(255,255,255,0.08);
        flex-shrink: 0;
    }

    /* EMPTY STATE */
    .empty-box {
        background: rgba(255,255,255,0.03);
        border: 1px dashed rgba(255,255,255,0.12);
    }
</style>

<div class="min-h-screen py-12">

    <div class="max-w-5xl mx-auto px-4">

        <!-- HEADER -->
        <div class="mb-6">

            <h2 class="text-3xl font-bold text-white">
                Notifications
            </h2>

            <p class="glass-muted mt-2">
                System notifications and updates
            </p>

        </div>

        <!-- GLASS PANEL -->
        <div class="glass-wrapper rounded-3xl p-6 shadow-2xl">

            @forelse(auth()->user()->notifications as $notification)

                <!-- NOTIFICATION ITEM -->
                <div class="notif-card rounded-2xl p-5 mb-4">

                    <div class="flex items-start justify-between gap-4">

                        <!-- LEFT -->
                        <div class="flex items-start gap-4">

                            <!-- ICON -->
                            <div class="notif-icon">
                                🔔
                            </div>

                            <!-- CONTENT -->
                            <div>

                                <p class="text-white text-lg font-medium leading-relaxed">
                                    {{ $notification->data['message'] }}
                                </p>

                                <p class="glass-muted text-sm mt-2">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>

                            </div>

                        </div>

                        <!-- BUTTON -->
                        @if(isset($notification->data['link']))

                            <a href="{{ $notification->data['link'] }}"
                               class="glass-btn text-sm whitespace-nowrap">

                                View

                            </a>

                        @endif

                    </div>

                </div>

            @empty

                <!-- EMPTY -->
                <div class="empty-box rounded-2xl text-center py-16">

                    <div class="text-5xl mb-4">
                        🔔
                    </div>

                    <p class="text-white/70 text-xl font-semibold">
                        No notifications yet
                    </p>

                    <p class="glass-muted mt-2">
                        You're all caught up.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

</x-app-layout>