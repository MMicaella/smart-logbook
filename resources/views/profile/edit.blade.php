<x-app-layout>

<style>
    body {
        background:
            linear-gradient(rgba(30,0,0,0.82), rgba(0,0,0,0.88)),
            url('/images/osmena-logo.png');

        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
    }

    header {
        background: transparent !important;
        box-shadow: none !important;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.10);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.35);
        color: white;
    }
</style>

<div class="max-w-6xl mx-auto py-10">

    <h2 class="text-2xl font-bold text-white mb-6">
        Profile Settings
    </h2>
        {{-- <p style="color:white; font-size:12px;">
    ID: {{ $user->id }} <br>
    PHOTO: {{ $user->profile_photo }} <br>
    UPDATED: {{ $user->updated_at }}
</p> --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- ================= PROFILE ================= -->
        <div class="glass-card p-6 space-y-5">

            <h3 class="text-lg font-semibold border-b border-white/10 pb-2">
                Profile Information
            </h3>

            <!-- PROFILE PHOTO FIXED -->
            <div class="flex items-center gap-4">

    {{-- PROFILE IMAGE (DISPLAY) --}}
    <img
        src="{{ $user->profile_photo
            ? asset('storage/' . $user->profile_photo) . '?v= ' . $user->updated_at
            : '/images/default-avatar.png' }}"
        class="w-20 h-20 rounded-full border border-white/20 object-cover"
    >

    {{-- UPLOAD FORM --}}
    <form method="POST"
          action="{{ route('profile.update') }}"
          enctype="multipart/form-data"
          class="flex flex-col gap-2">

        @csrf
        @method('PATCH')

        <input type="file"
               name="profile_photo"
               accept="image/*"
               class="text-xs text-white/70">

        <button type="submit"
                class="text-blue-300 text-xs hover:underline">
            Change Photo
        </button>

    </form>

</div>

            <!-- NAME -->
            <div>
                <label class="text-xs text-white/60">Name</label>
                <p class="font-semibold">{{ $user->name }}</p>
            </div>

            <!-- EMAIL -->
            <div>
                <label class="text-xs text-white/60">Email</label>
                <p class="font-semibold">{{ $user->email }}</p>
            </div>

            <!-- DEPARTMENT -->
            <div>
                <label class="text-xs text-white/60">Department</label>
                <p class="font-semibold">
                    {{ $user->department ?? 'Not Assigned' }}
                </p>
            </div>

        </div>

        <!-- ================= SECURITY ================= -->
        <div class="space-y-6">

            <div class="glass-card p-6">

                <h3 class="text-lg font-semibold border-b border-white/10 pb-2 mb-4">
                    Update Password
                </h3>

                <form method="post" action="{{ route('password.update') }}" class="space-y-4">

                    @csrf
                    @method('PUT')

                    <input type="password"
                           name="current_password"
                           placeholder="Current Password"
                           class="w-full p-2 rounded bg-white/10 text-white border border-white/20">

                    <input type="password"
                           name="password"
                           placeholder="New Password"
                           class="w-full p-2 rounded bg-white/10 text-white border border-white/20">

                    <input type="password"
                           name="password_confirmation"
                           placeholder="Confirm Password"
                           class="w-full p-2 rounded bg-white/10 text-white border border-white/20">

                    <button class="bg-blue-500/30 px-4 py-2 rounded text-blue-200 hover:bg-blue-500/40">
                        Save Password
                    </button>

                </form>

            </div>

            <div class="glass-card p-6">

                <h3 class="text-lg font-semibold border-b border-white/10 pb-2 mb-4">
                    Danger Zone
                </h3>

                <x-danger-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                    Delete Account
                </x-danger-button>

            </div>

        </div>

    </div>

    <!-- MODAL -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>

        <form method="POST"
              action="{{ route('profile.destroy') }}"
              class="p-6 bg-gray-900 text-white rounded-lg">

            @csrf
            @method('DELETE')

            <h2 class="text-lg font-bold">
                Confirm Delete Account
            </h2>

            <input type="password"
                   name="password"
                   placeholder="Password"
                   class="w-full mt-4 p-2 rounded bg-white/10 border border-white/20 text-white">

            <div class="flex justify-end gap-2 mt-6">

                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancel
                </x-secondary-button>

                <x-danger-button>
                    Delete
                </x-danger-button>

            </div>

        </form>

    </x-modal>

</div>

</x-app-layout>