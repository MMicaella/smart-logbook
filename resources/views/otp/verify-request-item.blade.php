<x-app-layout>

    <x-slot name="header">
        <div class="glass-card p-5 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white">
                Request Item OTP Verification
            </h2>

            <p class="text-white/70 mt-2 text-sm md:text-base">
                Enter the OTP sent to your account to confirm the request
            </p>
        </div>
    </x-slot>

    <style>
        body {
            background:
                linear-gradient(rgba(20,0,0,0.85), rgba(0,0,0,0.92)),
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
            box-shadow: 0 10px 40px rgba(0,0,0,0.35);
        }

        .otp-container {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }

        .otp-card {
            width: 100%;
            max-width: 420px;
            padding: 28px;
        }

        .otp-title {
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            color: white;
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: rgba(255,255,255,0.8);
            font-weight: 600;
            font-size: 14px;
        }

        .otp-input {
            width: 100%;
            padding: 14px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.15);
            background: rgba(255,255,255,0.05);
            color: white;
            outline: none;
            font-size: 16px;
        }

        .otp-input:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96,165,250,0.15);
        }

        .btn-primary {
            width: 100%;
            margin-top: 16px;
            padding: 14px;
            border-radius: 14px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            transition: 0.25s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37,99,235,0.35);
        }

        .error-box {
            background: rgba(239,68,68,0.15);
            color: #f87171;
            padding: 10px 12px;
            border-radius: 12px;
            margin-bottom: 12px;
            border: 1px solid rgba(239,68,68,0.25);
            font-size: 13px;
        }

        .countdown {
            margin-top: 14px;
            text-align: center;
            font-weight: 600;
            color: #fca5a5;
            font-size: 14px;
        }

        .resend-btn {
            margin-top: 10px;
            width: 100%;
            padding: 10px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .resend-disabled {
            background: rgba(59,130,246,0.4);
            color: white;
            opacity: 0.5;
            cursor: not-allowed;
        }

        .resend-enabled {
            background: #2563eb;
            color: white;
        }
    </style>

    <div class="otp-container">

        <div class="glass-card otp-card">

            <div class="otp-title">
                OTP Verification
            </div>

            @if(session('error'))
                <div class="error-box">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="/request-item/verify-otp">
                @csrf

                <label>OTP Code</label>

                <input type="text"
                       name="otp"
                       class="otp-input"
                       placeholder="Enter 6-digit OTP"
                       required>

                <button class="btn-primary">
                    Verify OTP
                </button>
            </form>

            {{-- Countdown --}}
            <p id="countdown" class="countdown"></p>

            {{-- Resend --}}
            <form method="POST" action="{{ route('otp.resend') }}">
                @csrf

                <button type="submit"
                        id="resendBtn"
                        class="resend-btn resend-disabled"
                        disabled>
                    Resend OTP
                </button>
            </form>

        </div>
    </div>

    <script>
        const expiryTime = @json(session('otp_expires_at') ?? null);

        const countdownEl = document.getElementById('countdown');
        const resendBtn = document.getElementById('resendBtn');

        function updateCountdown() {

            if (!expiryTime) {
                countdownEl.innerHTML = "No OTP timer found";
                return;
            }

            const now = Math.floor(Date.now() / 1000);
            const remaining = expiryTime - now;

            if (remaining <= 0) {
                countdownEl.innerHTML = "OTP Expired";

                resendBtn.disabled = false;
                resendBtn.classList.remove('resend-disabled');
                resendBtn.classList.add('resend-enabled');

                return;
            }

            const minutes = Math.floor(remaining / 60);
            const seconds = remaining % 60;

            countdownEl.innerHTML =
                `OTP expires in ${minutes}:${seconds.toString().padStart(2, '0')}`;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>

</x-app-layout>