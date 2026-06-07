```blade
<x-app-layout>

<x-slot name="header">
    <div class="glass-card">
        <h2 class="text-3xl font-bold text-white">
            OTP Verification
        </h2>

        <p class="glass-muted mt-2">
            Verify your borrow request using the OTP sent to your account
        </p>
    </div>
</x-slot>

<style>

body{
    background:
        linear-gradient(rgba(30,0,0,0.88), rgba(0,0,0,0.92)),
        url('/images/osmena-logo.png');

    background-size: contain;
    background-repeat:no-repeat;
    background-position:center;
    background-attachment:fixed;
}

header,
nav,
main,
.bg-white{
    background:transparent !important;
    box-shadow:none !important;
    border:none !important;
}

.shadow{
    box-shadow:none !important;
}

.glass-card{
    background:rgba(255,255,255,.08);
    backdrop-filter:blur(18px);
    -webkit-backdrop-filter:blur(18px);

    border:1px solid rgba(255,255,255,.12);
    border-radius:24px;

    padding:24px;

    box-shadow:0 10px 40px rgba(0,0,0,.35);
}

.glass-muted{
    color:rgba(255,255,255,.7);
}

.otp-wrapper{
    display:flex;
    justify-content:center;
    align-items:center;

    padding:40px 16px;
}

.otp-box{
    width:100%;
    max-width:500px;

    background:rgba(255,255,255,.08);
    backdrop-filter:blur(18px);
    -webkit-backdrop-filter:blur(18px);

    border:1px solid rgba(255,255,255,.12);
    border-radius:24px;

    padding:30px;

    box-shadow:0 10px 40px rgba(0,0,0,.35);
}

.otp-title{
    text-align:center;
    font-size:24px;
    font-weight:bold;
    color:white;
    margin-bottom:25px;
}

label{
    display:block;
    margin-bottom:10px;
    color:rgba(255,255,255,.8);
    font-weight:600;
}

.otp-input{
    width:100%;

    padding:16px;

    border-radius:14px;

    border:1px solid rgba(255,255,255,.15);

    background:rgba(255,255,255,.05);

    color:white;
    font-size:18px;
    text-align:center;
    letter-spacing:5px;

    outline:none;
}

.otp-input:focus{
    border-color:#4ade80;
}

.otp-input::placeholder{
    color:rgba(255,255,255,.45);
    letter-spacing:normal;
}

.btn-primary{
    width:100%;

    margin-top:20px;

    padding:14px;

    border:none;
    border-radius:14px;

    cursor:pointer;

    font-weight:bold;
    color:white;

    background:linear-gradient(135deg,#22c55e,#16a34a);

    transition:.3s;
}

.btn-primary:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(34,197,94,.4);
}

.countdown-box{
    margin-top:20px;

    background:rgba(255,255,255,.05);

    border:1px solid rgba(255,255,255,.08);

    border-radius:16px;

    padding:15px;

    text-align:center;
}

.countdown-text{
    color:#fca5a5;
    font-weight:600;
}

.resend-btn{
    width:100%;

    margin-top:15px;

    padding:12px;

    border:none;
    border-radius:14px;

    background:linear-gradient(135deg,#22c55e,#15803d);

    color:white;
    font-weight:bold;

    transition:.3s;
}

.resend-btn:hover:not(:disabled){
    transform:translateY(-2px);
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
</style>

<div class="otp-wrapper">

    <div class="otp-box">

        <div class="otp-title">
            OTP Verification
        </div>

        @if(session('error'))
            <div class="error-box">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/borrow/verify-otp">
            @csrf

            <label>
                Enter OTP Code
            </label>

            <input type="text"
                   name="otp"
                   maxlength="6"
                   class="otp-input"
                   placeholder="Enter 6-digit OTP"
                   required>

            <button type="submit" class="btn-primary">
                Verify OTP
            </button>
        </form>

        <div class="countdown-box">

            <p id="countdown" class="countdown-text"></p>

            <form method="POST"
                  action="{{ route('otp.resend') }}">
                @csrf

                <button type="submit"
                        id="resendBtn"
                        class="resend-btn"
                        disabled>

                    Resend OTP

                </button>
            </form>

        </div>

    </div>

</div>

<script>

const expiryTime =
{{ session('otp_expires_at') ?? now()->addHours(24)->timestamp }};

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

    const hours =
        Math.floor(remaining / 3600);

    const minutes =
        Math.floor((remaining % 3600) / 60);

    const seconds =
        remaining % 60;

    countdownEl.innerHTML =
        `OTP expires in ${hours}h ${minutes}m ${seconds}s`;
}

updateCountdown();

setInterval(updateCountdown, 1000);

</script>

</x-app-layout>

