<x-app-layout>

<style>

    /* ===============================
       🔥 GLOBAL BACKGROUND FIX
    =============================== */

    .min-h-screen.bg-gray-100{
        background: transparent !important;
    }

    body{
        background:
            linear-gradient(rgba(25,0,0,0.82), rgba(0,0,0,0.90)),
            url('{{ asset('images/osmena-logo.png') }}');

        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;

        min-height: 100vh;
    }

    header{
        background: transparent !important;
        box-shadow: none !important;
    }

    /* ===============================
       🔥 GLASS CARD
    =============================== */

    .glass-card{
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);

        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 28px;

        box-shadow: 0 8px 32px rgba(0,0,0,0.35);
    }

    /* ===============================
       🔥 INPUTS
    =============================== */

    .glass-input{
        width: 100%;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.15);
        color: white;

        padding: 12px 14px;
        border-radius: 14px;

        outline: none;
        transition: 0.3s;
    }

    .glass-input:focus{
        border-color: rgba(255,255,255,0.35);
        box-shadow: 0 0 0 3px rgba(255,255,255,0.08);
    }

    .glass-input option{
        color: black;
    }

    label{
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* ===============================
       🔥 BUTTON
    =============================== */

    .glass-button{
        background: rgba(59,130,246,0.25);
        border: 1px solid rgba(96,165,250,0.35);
        color: white;

        padding: 12px 18px;
        border-radius: 14px;

        font-weight: 600;
        transition: 0.3s;
    }

    .glass-button:hover{
        background: rgba(59,130,246,0.40);
        transform: translateY(-2px);
    }

</style>

<x-slot name="header">

    <div class="glass-card p-5">
        <h2 class="text-xl font-bold text-white">
            Create Staff Account
        </h2>
    </div>

</x-slot>

<div class="py-10 px-4">

<div class="max-w-4xl mx-auto glass-card p-8">
    {{-- SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="mb-5 p-4 rounded-xl bg-green-500/20 border border-green-400/30 text-green-200">
        {{ session('success') }}
    </div>
@endif

{{-- ERROR MESSAGE --}}
@if(session('error'))
    <div class="mb-5 p-4 rounded-xl bg-red-500/20 border border-red-400/30 text-red-200">
        {{ session('error') }}
    </div>
@endif

{{-- VALIDATION ERRORS --}}
@if($errors->any())
    <div class="mb-5 p-4 rounded-xl bg-red-500/20 border border-red-400/30 text-red-200">
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="/admin/users/store" method="POST">
        @csrf

        <!-- GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <!-- NAME -->
            <div>
                <label>Name</label>
                <input type="text" name="name" class="glass-input mt-2" required>
            </div>

            <!-- EMAIL -->
            <div>
                <label>Email</label>
                <input type="email" name="email" class="glass-input mt-2" required>
            </div>

            <!-- PASSWORD -->
            <div>
                <label>Password</label>
                <input type="password" name="password" class="glass-input mt-2" required>
            </div>

            <!-- ROLE -->
            <div>
                <label>Role</label>
                <select name="role" class="glass-input mt-2">

                    <option value="admin">Admin</option>
                    <option value="custodian">Custodian</option>
                    <option value="checker">Checker</option>
                    <option value="user">Standard User</option>

                </select>
            </div>

            <!-- DEPARTMENT (FULL WIDTH) -->
            <div class="md:col-span-2">
                <label>Department</label>

                <select name="department" class="glass-input mt-2">

                    <option>IT Department</option>
                    <option>Accounting Department</option>
                    <option>CTE Department</option>
                    <option>CCJE Department</option>
                    <option>CABA Department</option>
                    <option>CCS Department</option>
                    <option>CHM Department</option>
                    <option>College of Arts and Sciences</option>
                    <option>Graduate School</option>
                    <option>Basic Education</option>
                    <option>SHS (Academic and TVL)</option>

                </select>
            </div>

        </div>

        <!-- BUTTON -->
        <div class="mt-8">
            <button class="glass-button w-full">
                Create Account
            </button>
        </div>

    </form>

</div>

</div>

</x-app-layout>