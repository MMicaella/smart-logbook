<x-app-layout>

<x-slot name="header">
    <h2 class="text-xl font-bold">
        Release Item
    </h2>
</x-slot>

<div class="py-10">

<div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl p-8">

    <!-- SUCCESS -->
    @if(session('success'))

        <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-xl mb-6">

            {{ session('success') }}

        </div>

    @endif

    <!-- ERRORS -->
    @if ($errors->any())

        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl mb-6">

            <ul class="list-disc ml-5">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <!-- TITLE -->
    <div class="flex items-center justify-between mb-8">

        <h2 class="text-2xl font-bold text-gray-800">
            Borrow Request Details
        </h2>

        <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-semibold">

            Ready for Release

        </span>

    </div>

    <!-- BORROW INFO -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">

        <!-- ITEM -->
        <div class="border rounded-xl p-4">

            <p class="text-sm text-gray-500 mb-1">
                Item
            </p>

            <p class="font-semibold text-lg">
                {{ $borrow->item->item_name }}
            </p>

        </div>

        <!-- BORROWER -->
        <div class="border rounded-xl p-4">

            <p class="text-sm text-gray-500 mb-1">
                Borrower
            </p>

            <p class="font-semibold">
                {{ $borrow->user->name }}
            </p>

        </div>

        <!-- QUANTITY -->
        <div class="border rounded-xl p-4">

            <p class="text-sm text-gray-500 mb-1">
                Quantity Requested
            </p>

            <p class="font-bold text-blue-600 text-xl">
                {{ $borrow->quantity }}
            </p>

        </div>

        <!-- DEPARTMENT -->
        <div class="border rounded-xl p-4">

            <p class="text-sm text-gray-500 mb-1">
                Department
            </p>

            <p class="font-semibold">
                {{ $borrow->department }}
            </p>

        </div>

    </div>

    <hr class="my-8">

    <!-- RELEASE FORM -->
    <form method="POST"
          action="/custodian/borrowings/{{ $borrow->id }}/release">

        @csrf
        @method('PUT')

        <!-- BRAND -->
        <div class="mb-6">

            <label class="block font-semibold mb-2">
                Brand Name
            </label>

            <input type="text"
                   name="brand_name"
                   value="{{ old('brand_name') }}"
                   class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500"
                   placeholder="Enter item brand"
                   required>

        </div>

        <!-- SERIAL NUMBERS -->
        <div class="mb-6">

            <label class="block font-semibold mb-3">
                Serial Numbers
            </label>

            <div class="space-y-4">

                @for($i = 1; $i <= $borrow->quantity; $i++)

                    <div class="border rounded-xl p-4 bg-gray-50">

                        <label class="block text-sm text-gray-600 mb-2">

                            Serial Number #{{ $i }}

                        </label>

                        <input type="text"
                               name="serial_numbers[]"
                               value="{{ old('serial_numbers.' . ($i-1)) }}"
                               class="w-full border border-gray-300 rounded-lg p-3 font-mono focus:ring-2 focus:ring-blue-500"
                               placeholder="Enter serial number"
                               required>

                    </div>

                @endfor

            </div>

        </div>

        <!-- REMARKS -->
        <div class="mb-8">

            <label class="block font-semibold mb-2">
                Item Condition / Remarks
            </label>

            <textarea name="remarks"
                      rows="4"
                      class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500"
                      placeholder="Example: Good condition, complete accessories, slightly scratched...">{{ old('remarks') }}</textarea>

        </div>

        <!-- BUTTON -->
        <button class="w-full bg-green-600 hover:bg-green-700 text-white py-4 rounded-xl font-semibold text-lg transition">

            Confirm Release

        </button>

    </form>

</div>

</div>

</x-app-layout>