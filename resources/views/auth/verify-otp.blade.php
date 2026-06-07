<x-app-layout>

<div class="flex justify-center items-center min-h-screen bg-gray-100">

    <div class="bg-white w-96 p-8 rounded-2xl shadow-xl">

        <h2 class="text-2xl font-bold text-center mb-2">
            OTP Verification
        </h2>

        <p class="text-gray-500 text-sm text-center mb-6">
            Enter the 6-digit OTP sent to your email
        </p>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))

            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm">

                {{ session('success') }}

            </div>

        @endif

        {{-- ERROR MESSAGE --}}
        @if(session('error'))

            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm">

                {{ session('error') }}

            </div>

        @endif

        {{-- VERIFY OTP --}}
        <form method="POST" action="/borrow/verify-otp">

            @csrf

            <input
                type="text"
                name="otp"
                placeholder="Enter OTP"
                maxlength="6"
                class="w-full border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 p-3 rounded-xl mb-5"
                required
            >

            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl transition">

                Verify OTP

            </button>

        </form>

        {{-- RESEND OTP --}}
        <form method="POST" action="/otp/resend" class="mt-4">

            @csrf

            <button
                type="submit"
                class="w-full border border-gray-300 hover:bg-gray-100 text-gray-700 py-3 rounded-xl transition">

                Resend OTP

            </button>

        </form>

    </div>

</div>

</x-app-layout>