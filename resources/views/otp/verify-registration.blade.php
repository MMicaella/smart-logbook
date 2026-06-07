<x-app-layout>

<x-slot name="header">
    <div class="glass-card">
        <h2 class="text-3xl font-bold text-white text-center">
            Verify Your Email
        </h2>

        <p class="text-gray-300 text-sm text-center mt-2">
            Enter the 6-digit OTP sent to your email
        </p>

        <div class="text-center mt-4">
            <span class="text-red-400 font-semibold">
                OTP expires in:
            </span>

            <span id="countdown" class="font-bold text-red-500">
                --
            </span>
        </div>
    </div>
</x-slot>

<style>
    body {
        background:
            linear-gradient(rgba(30,0,0,0.88), rgba(0,0,0,0.92)),
            url('/images/osmena-logo.png');

        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
    }

    .glass-card {
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);

        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 24px;

        padding: 24px;

        box-shadow: 0 10px 40px rgba(0,0,0,0.35);
    }

    .otp-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 16px;
    }

    .otp-card {
        width: 100%;
        max-width: 480px;

        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);

        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 24px;

        padding: 30px;

        box-shadow: 0 10px 40px rgba(0,0,0,0.35);
    }

    .otp-desc {
        text-align: center;
        color: rgba(255,255,255,0.7);
        font-size: 14px;
        margin-bottom: 25px;
    }

    .otp-grid {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 25px;
    }

    .otp-input {
        width: 48px;
        height: 52px;

        text-align: center;
        font-size: 20px;
        font-weight: bold;

        border-radius: 14px;
        border: 1px solid rgba(255,255,255,0.15);

        background: rgba(255,255,255,0.05);
        color: white;

        outline: none;
    }

    .otp-input:focus {
        border-color: #60a5fa;
        transform: scale(1.05);
    }

    .btn-primary {
        width: 100%;
        padding: 14px;

        border-radius: 14px;
        border: none;

        cursor: pointer;
        font-weight: bold;

        color: white;
        background: linear-gradient(135deg, #3b82f6, #2563eb);

        transition: .3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(37,99,235,0.4);
    }

    .error-box {
        background: rgba(239,68,68,0.15);
        color: #f87171;

        padding: 12px;
        border-radius: 14px;

        margin-bottom: 15px;

        border: 1px solid rgba(239,68,68,0.25);
    }

    header,
    nav,
    main,
    .bg-white,
    .shadow {
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }
</style>

<div class="otp-wrapper">

    <div class="otp-card">

        <p class="otp-desc">
            Enter the 6-digit OTP sent to your email
        </p>

        @if(session('error'))
            <div class="error-box">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/otp/verify">
            @csrf

            <div class="otp-grid">
                <input name="otp1" maxlength="1" class="otp-input" required>
                <input name="otp2" maxlength="1" class="otp-input" required>
                <input name="otp3" maxlength="1" class="otp-input" required>
                <input name="otp4" maxlength="1" class="otp-input" required>
                <input name="otp5" maxlength="1" class="otp-input" required>
                <input name="otp6" maxlength="1" class="otp-input" required>
            </div>

            <button class="btn-primary">
                Verify OTP
            </button>
        </form>

    </div>
</div>

<script>
const expiryTime = {{ session('otp_expires_at') ?? 0 }};

const countdownEl = document.getElementById('countdown');

function updateCountdown()
{
    const now = Math.floor(Date.now() / 1000);
    const remaining = expiryTime - now;

    if (remaining <= 0) {
        countdownEl.innerHTML = "OTP Expired";
        return;
    }

    const minutes = Math.floor(remaining / 60);
    const seconds = remaining % 60;

    countdownEl.innerHTML =
        `${minutes}:${seconds.toString().padStart(2,'0')}`;
}

updateCountdown();
setInterval(updateCountdown, 1000);
</script>

</x-app-layout>