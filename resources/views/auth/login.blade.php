<x-guest-layout>

<style>

    /* ===============================
       🔥 FULL PAGE BACKGROUND
    =============================== */

    html,
    body{
        height: 100%;
        margin: 0;
    }

    body{

        font-family: 'Poppins', sans-serif;

        background:
            linear-gradient(rgba(30,0,0,0.82), rgba(0,0,0,0.90)),
            url('{{ asset('images/osmena-logo.png') }}') center center / contain no-repeat fixed !important;

        min-height: 100vh;

        overflow: hidden;
    }

    /* REMOVE BREEZE BACKGROUNDS */

    .min-h-screen{
        background: transparent !important;
    }

    .bg-gray-100,
    .dark\:bg-gray-900,
    .bg-white,
    .dark\:bg-gray-800{
        background: transparent !important;
    }

    /* REMOVE DEFAULT LOGO */

    .w-20.h-20.fill-current.text-gray-500{
        display: none !important;
    }

    /* REMOVE DEFAULT SHADOW */

    .shadow-md,
    .shadow{
        box-shadow: none !important;
    }

    /* ===============================
       🔥 CENTER CONTAINER
    =============================== */

    .login-wrapper{

        min-height: 100vh;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 20px;
    }

    /* ===============================
       🔥 GLASS CARD
    =============================== */

    .glass-card{

        width: 100%;
        max-width: 480px;

        background: rgba(255,255,255,0.10);

        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);

        border: 1px solid rgba(255,255,255,0.18);

        border-radius: 28px;

        box-shadow: 0 8px 32px rgba(0,0,0,0.35);

        padding: 42px;
    }

    /* ===============================
       🔥 TITLE
    =============================== */

    .login-title{

        font-size: 2.5rem;
        font-weight: 800;

        color: white;
    }

    .login-subtitle{

        color: rgba(255,255,255,0.65);

        margin-top: 10px;
    }

    /* ===============================
       🔥 INPUTS
    =============================== */

    .glass-input{

        width: 100%;

        background: rgba(255,255,255,0.08) !important;

        border: 1px solid rgba(255,255,255,0.15) !important;

        color: white !important;

        padding: 14px !important;

        border-radius: 14px !important;

        outline: none;

        transition: 0.3s;
    }

    .glass-input:focus{

        border-color: rgba(255,255,255,0.35) !important;

        box-shadow:
            0 0 0 3px rgba(255,255,255,0.08) !important;
    }

    .glass-input::placeholder{
        color: rgba(255,255,255,0.45);
    }

    label{

        color: white !important;

        font-weight: 600;
    }

    /* ===============================
       🔥 BUTTON
    =============================== */

    .glass-button{

        background: rgba(59,130,246,0.25) !important;

        border: 1px solid rgba(96,165,250,0.35) !important;

        color: white !important;

        padding: 12px 22px !important;

        border-radius: 14px !important;

        font-weight: 600;

        transition: 0.3s;
    }

    .glass-button:hover{

        background: rgba(59,130,246,0.40) !important;

        transform: translateY(-1px);
    }

    /* ===============================
       🔥 LINKS
    =============================== */

    .glass-link{

        color: rgba(255,255,255,0.75);

        transition: 0.3s;
    }

    .glass-link:hover{
        color: white;
    }

    /* ===============================
       🔥 CHECKBOX
    =============================== */

    input[type="checkbox"]{

        background: rgba(255,255,255,0.10) !important;

        border-color: rgba(255,255,255,0.25) !important;
    }

    /* ===============================
       🔥 ERRORS
    =============================== */

    .text-red-600,
    .text-red-500{
        color: rgb(252,165,165) !important;
    }

    .text-green-600{
        color: rgb(187,247,208) !important;
    }

</style>

<div class="login-wrapper">

    <div class="glass-card">

        <!-- TITLE -->
        <div class="text-center mb-8">

            <h1 class="login-title">
                Smart LogBook
            </h1>

            <p class="login-subtitle">
                Sign in to continue
            </p>

        </div>

        <!-- SESSION STATUS -->
        <x-auth-session-status
            class="mb-4 text-green-300"
            :status="session('status')" />

        <form method="POST"
              action="{{ route('login') }}">

            @csrf

            <!-- EMAIL -->
            <div>

                <x-input-label for="email"
                               :value="__('Email')" />

                <x-text-input
                    id="email"
                    class="glass-input block mt-2"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username" />

                <x-input-error
                    :messages="$errors->get('email')"
                    class="mt-2 text-red-300" />

            </div>

            <!-- PASSWORD -->
            <div class="mt-5">

                <x-input-label for="password"
                               :value="__('Password')" />

                <x-text-input
                    id="password"
                    class="glass-input block mt-2"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password" />

                <x-input-error
                    :messages="$errors->get('password')"
                    class="mt-2 text-red-300" />

            </div>

            {{-- <!-- REMEMBER -->
            <div class="block mt-5">

                <label for="remember_me"
                       class="inline-flex items-center">

                    <input id="remember_me"
                           type="checkbox"
                           class="rounded"
                           name="remember">

                    <span class="ms-2 text-sm text-white/70">
                        {{ __('Remember me') }}
                    </span>

                </label>

            </div> --}}

            <!-- ACTIONS -->
            <div class="flex items-center justify-between mt-6">

                @if (Route::has('password.request'))

                    <a class="glass-link underline text-sm"
                       href="{{ route('password.request') }}">

                        {{ __('Forgot your password?') }}

                    </a>

                @endif

                <x-primary-button class="glass-button ms-3">

                    {{ __('Log in') }}

                </x-primary-button>

            </div>

        </form>

    </div>

</div>

</x-guest-layout>