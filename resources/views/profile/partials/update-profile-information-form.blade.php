<section>

    <header>

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information.") }}
        </p>

    </header>

    <form method="post"
          action="{{ route('profile.update') }}"
          enctype="multipart/form-data"
          class="mt-6 space-y-6">

        @csrf
        @method('patch')

        <!-- NAME -->
        <div>

            <x-input-label for="name" :value="__('Name')" />

            <x-text-input id="name"
                          name="name"
                          type="text"
                          class="mt-1 block w-full"
                          :value="old('name', $user->name)"
                          required
                          autofocus />

            <x-input-error class="mt-2"
                           :messages="$errors->get('name')" />

        </div>

        <!-- EMAIL -->
        <div>

            <x-input-label for="email" :value="__('Email')" />

            <x-text-input id="email"
                          name="email"
                          type="email"
                          class="mt-1 block w-full"
                          :value="old('email', $user->email)"
                          required />

            <x-input-error class="mt-2"
                           :messages="$errors->get('email')" />

        </div>

        <!-- EMPLOYEE NUMBER -->
        <div>

            <x-input-label for="employee_number"
                           :value="__('Employee Number')" />

            <x-text-input id="employee_number"
                          name="employee_number"
                          type="text"
                          class="mt-1 block w-full"
                          :value="old('employee_number', $user->employee_number)" />

        </div>

        <!-- DEPARTMENT -->
        <div>

            <x-input-label for="department"
                           :value="__('Department')" />

            <x-text-input id="department"
                          name="department"
                          type="text"
                          class="mt-1 block w-full"
                          :value="old('department', $user->department)" />

        </div>

        <!-- PROFILE PHOTO -->
        <div>

            <x-input-label for="profile_photo"
                           :value="__('Profile Photo')" />

            <input type="file"
                   name="profile_photo"
                   class="mt-1 block w-full border rounded p-2">

        </div>

        <!-- EMAIL VERIFIED STATUS -->
        <div>

            @if($user->email_verified_at)

                <p class="text-green-600 text-sm">
                    ✔ Email Verified
                </p>

            @else

                <p class="text-red-600 text-sm">
                    ✖ Email Not Verified
                </p>

                <a href="/verify-otp"
                   class="text-blue-600 underline text-sm">
                    Verify Email Now
                </a>

            @endif

        </div>

        <!-- SAVE BUTTON -->
        <div class="flex items-center gap-4">

            <x-primary-button>
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')

                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-gray-600 dark:text-gray-400">

                    {{ __('Saved.') }}

                </p>

            @endif

        </div>

    </form>

</section>