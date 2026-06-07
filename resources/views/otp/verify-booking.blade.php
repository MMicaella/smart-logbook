<x-app-layout>

    <x-slot name="header">
        <div class="glass-card">
            <h2 class="text-3xl font-bold text-white">
                Vehicle Booking OTP Verification
            </h2>

            <p class="glass-muted mt-2">
                Enter the OTP sent to your registered account
            </p>
        </div>
    </x-slot>

    <style>

        body{
            background:
                linear-gradient(rgba(30,0,0,0.88), rgba(0,0,0,0.92)),
                url('/images/osmena-logo.png');

            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }

        .glass-card{
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);

            border:1px solid rgba(255,255,255,0.12);
            border-radius:24px;

            padding:24px;

            box-shadow:0 10px 40px rgba(0,0,0,.35);
        }

        .glass-muted{
            color:rgba(255,255,255,.7);
        }

        .otp-card{
            background:rgba(255,255,255,.08);

            backdrop-filter:blur(18px);
            -webkit-backdrop-filter:blur(18px);

            border:1px solid rgba(255,255,255,.12);
            border-radius:24px;

            padding:30px;

            box-shadow:0 10px 40px rgba(0,0,0,.35);
        }

        label{
            color:rgba(255,255,255,.85);
            font-weight:600;
            display:block;
            margin-bottom:10px;
        }

        .otp-input{
            width:100%;

            padding:14px;

            border-radius:14px;

            border:1px solid rgba(255,255,255,.15);

            background:rgba(255,255,255,.05);

            color:white;

            outline:none;

            font-size:16px;
        }

        .otp-input::placeholder{
            color:rgba(255,255,255,.5);
        }

        .otp-input:focus{
            border-color:#60a5fa;
        }

        .btn-primary{
            width:100%;

            margin-top:20px;

            padding:14px;

            border-radius:14px;

            border:none;

            color:white;
            font-weight:bold;

            cursor:pointer;

            background:linear-gradient(
                135deg,
                #3b82f6,
                #2563eb
            );

            transition:.3s;
        }

        .btn-primary:hover{
            transform:translateY(-2px);

            box-shadow:
                0 10px 20px rgba(37,99,235,.4);
        }

        .countdown-box{
            margin-top:18px;
            text-align:center;
        }

        .countdown-text{
            color:#fca5a5;
            font-weight:600;
            font-size:14px;
        }

        .resend-btn{
            width:100%;

            margin-top:15px;

            padding:14px;

            border:none;

            border-radius:14px;

            background:linear-gradient(
                135deg,
                #0ea5e9,
                #2563eb
            );

            color:white;

            font-weight:bold;

            cursor:pointer;

            transition:.3s;
        }

        .resend-btn:hover:not(:disabled){
            transform:translateY(-2px);

            box-shadow:
                0 10px 20px rgba(37,99,235,.35);
        }

        .resend-btn:disabled{
            opacity:.5;
            cursor:not-allowed;
        }

        .error-box{
            background:rgba(239,68,68,.15);

            color:#f87171;

            padding:12px;

            border-radius:14px;

            margin-bottom:15px;

            border:1px solid rgba(239,68,68,.25);
        }

        .success-box{
            background:rgba(34,197,94,.15);

            color:#86efac;

            padding:12px;

            border-radius:14px;

            margin-bottom:15px;

            border:1px solid rgba(34,197,94,.25);
        }

        header,
        nav,
        main,
        .bg-white,
        .shadow{
            background:transparent !important;
            box-shadow:none !important;
            border:none !important;
        }

        header > div{
            background:transparent !important;
            box-shadow:none !important;
            border:none !important;
            max-width:100% !important;
        }

    </style>

    <div class="py-10 px-4">

        <div class="max-w-md mx-auto">

            @if(session('error'))
                <div class="error-box">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="success-box">
                    {{ session('success') }}
                </div>
            @endif

            <div class="otp-card">

                <form method="POST"
                      action="/booking/verify-otp">

                    @csrf

                    <label>
                        Enter OTP Code
                    </label>

                    <input
                        type="text"
                        name="otp"
                        class="otp-input"
                        maxlength="6"
                        placeholder="Enter 6-digit OTP"
                        required>

                    <div class="countdown-box">

                        <p id="countdown"
                           class="countdown-text">
                        </p>

                    </div>

                    <button
                        type="submit"
                        class="btn-primary">

                        Verify OTP

                    </button>

                </form>

                <form method="POST"
                      action="{{ route('otp.resend') }}">

                    @csrf

                    <button
                        type="submit"
                        id="resendBtn"
                        disabled
                        class="resend-btn">

                        Resend OTP

                    </button>

                </form>

            </div>

        </div>

    </div>

    <script>

        const expiryTime =
            {{ session('otp_expires_at') ?? now()->addMinutes(60)->timestamp }};

        const countdownEl =
            document.getElementById('countdown');

        const resendBtn =
            document.getElementById('resendBtn');

        function updateCountdown()
        {
            const now =
                Math.floor(Date.now() / 1000);

            const remaining =
                expiryTime - now;

            if (remaining <= 0)
            {
                countdownEl.innerHTML =
                    "OTP Expired";

                resendBtn.disabled = false;

                return;
            }

            const minutes =
                Math.floor(remaining / 60);

            const seconds =
                remaining % 60;

            countdownEl.innerHTML =
                `OTP expires in ${minutes}:${seconds
                    .toString()
                    .padStart(2,'0')}`;
        }

        updateCountdown();

        setInterval(
            updateCountdown,
            1000
        );

    </script>

</x-app-layout>