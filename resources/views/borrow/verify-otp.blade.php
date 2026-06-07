<x-app-layout>

<div class="max-w-md mx-auto py-10">

    <div class="bg-white shadow-xl rounded-2xl p-8">

        <h2 class="text-2xl font-bold mb-6">
            OTP Verification
        </h2>

        @if(session('error'))

            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">

                {{ session('error') }}

            </div>

        @endif

        <form method="POST" action="/borrow/verify-otp">

            @csrf

            <input type="text"
                   name="otp"
                   placeholder="Enter OTP"
                   class="w-full border p-3 rounded-xl mb-5"
                   required>

            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl">

                Verify OTP

            </button>

        </form>

    </div>

</div>

</x-app-layout>