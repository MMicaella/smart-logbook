<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="w-full max-w-2xl bg-white shadow-xl rounded-2xl p-8">

        <!-- TITLE -->
        <div class="text-center mb-8">

            <h1 class="text-3xl font-bold text-gray-800">
                Smart LogBook
            </h1>

            <p class="text-gray-500 mt-2">
                Employee Registration
            </p>

        </div>

        <!-- ERROR MESSAGES -->
        @if ($errors->any())

            <div class="mb-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">

                <ul class="list-disc pl-5 text-sm">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <!-- SUCCESS -->
        @if(session('success'))

            <div class="mb-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">

                {{ session('success') }}

            </div>

        @endif

        <!-- PROGRESS -->
        <div class="flex items-center justify-between mb-10">

            <!-- STEP 1 -->
            <div class="text-center flex-1">

                <div id="circle1"
                     class="w-10 h-10 mx-auto rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                    1
                </div>

                <p class="text-sm mt-2">
                    Personal
                </p>

            </div>

            <div class="h-1 bg-gray-300 flex-1 mx-2"></div>

            <!-- STEP 2 -->
            <div class="text-center flex-1">

                <div id="circle2"
                     class="w-10 h-10 mx-auto rounded-full bg-gray-300 text-gray-700 flex items-center justify-center font-bold">
                    2
                </div>

                <p class="text-sm mt-2">
                    Account
                </p>

            </div>

        </div>

        <!-- FORM -->
        <form method="POST" action="{{ route('register') }}">

            @csrf

            <!-- STEP 1 -->
            <div id="step1">

                <!-- NAME -->
                <div class="mb-5">

                    <label class="block mb-2 font-medium">
                        Full Name
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="w-full border rounded-lg p-3"
                           required>

                </div>

                <!-- EMPLOYEE NUMBER -->
                <div class="mb-5">

                    <label class="block mb-2 font-medium">
                        Employee Number
                    </label>

                    <input type="text"
                           name="employee_number"
                           value="{{ old('employee_number') }}"
                           class="w-full border rounded-lg p-3"
                           required>

                </div>

                <!-- DEPARTMENT -->
                <div class="mb-5">

                    <label class="block mb-2 font-medium">
                        Department
                    </label>

                    <select name="department"
                            class="w-full border rounded-lg p-3"
                            required>

                        <option value="">
                            Select Department
                        </option>

                        <option value="HR Department">HR Department</option>
                        <option value="Accounting Office">Accounting Office</option>
                        <option value="Registrar Office">Registrar Office</option>
                        <option value="Library">Library</option>
                        <option value="Guidance Office">Guidance Office</option>
                        <option value="IT Department">IT Department</option>
                        <option value="Accounting Department">Accounting Department</option>
                        <option value="CTE Department">CTE Department</option>
                        <option value="CCJE Department">CCJE Department</option>
                        <option value="CABA Department">CABA Department</option>
                        <option value="CCS Department">CCS Department</option>
                        <option value="CHM Department">CHM Department</option>
                        <option value="College of Arts and Sciences">College of Arts and Sciences</option>
                        <option value="Graduate School">Graduate School</option>
                        <option value="Basic Education">Basic Education</option>
                        <option value="SHS (Academic and TVL)">SHS (Academic and TVL)</option>

                    </select>

                </div>

                <!-- NEXT -->
                <button type="button"
                        onclick="nextStep(1)"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg">

                    Next

                </button>

            </div>

            <!-- STEP 2 -->
            <div id="step2" class="hidden">

                <!-- EMAIL -->
                <div class="mb-5">

                    <label class="block mb-2 font-medium">
                        Email Address
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="w-full border rounded-lg p-3"
                           required>

                </div>

                <!-- PASSWORD -->
                <div class="mb-5">

                    <label class="block mb-2 font-medium">
                        Password
                    </label>

                    <input type="password"
                           name="password"
                           class="w-full border rounded-lg p-3"
                           required>

                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="mb-5">

                    <label class="block mb-2 font-medium">
                        Confirm Password
                    </label>

                    <input type="password"
                           name="password_confirmation"
                           class="w-full border rounded-lg p-3"
                           required>

                </div>

                <!-- BUTTONS -->
                <div class="flex gap-3">

                    <button type="button"
                            onclick="prevStep(2)"
                            class="w-1/2 bg-gray-300 hover:bg-gray-400 py-3 rounded-lg">

                        Back

                    </button>

                    <button type="submit"
                            class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg">

                        Register

                    </button>

                </div>

            </div>

        </form>

        <!-- LOGIN -->
        <div class="mt-8 text-center">

            <p class="text-gray-600">
                Already have an account?
            </p>

            <a href="{{ route('login') }}"
               class="inline-block mt-3 bg-gray-800 hover:bg-gray-900 text-white px-6 py-2 rounded-lg">

                Login

            </a>

        </div>

    </div>

</div>

<script>

function nextStep(step){

    document.getElementById('step'+step)
        .classList.add('hidden');

    document.getElementById('step'+(step+1))
        .classList.remove('hidden');

    document.getElementById('circle'+(step+1))
        .classList.remove('bg-gray-300','text-gray-700');

    document.getElementById('circle'+(step+1))
        .classList.add('bg-blue-600','text-white');
}

function prevStep(step){

    document.getElementById('step'+step)
        .classList.add('hidden');

    document.getElementById('step'+(step-1))
        .classList.remove('hidden');

    document.getElementById('circle'+step)
        .classList.remove('bg-blue-600','text-white');

    document.getElementById('circle'+step)
        .classList.add('bg-gray-300','text-gray-700');
}

</script>

</x-guest-layout>