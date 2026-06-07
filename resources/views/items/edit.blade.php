<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Update Item Quantity
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="/custodian/items/{{ $item->id }}">

                    @csrf
                    @method('PUT')

                    <!-- ITEM NAME -->
                    <div class="mb-5">

                        <x-input-label :value="__('Item Name')" />

                        <div class="mt-2 p-3 rounded bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                            {{ $item->name }}
                        </div>

                    </div>

                    <!-- CURRENT QUANTITY -->
                    <div class="mb-5">

                        <x-input-label :value="__('Current Quantity')" />

                        <div class="mt-2 p-3 rounded bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                            {{ $item->quantity }}
                        </div>

                    </div>

                    <!-- NEW QUANTITY -->
                    <div class="mb-5">

                        <x-input-label for="quantity"
                                       :value="__('New Quantity')" />

                        <x-text-input id="quantity"
                                      class="block mt-1 w-full"
                                      type="number"
                                      name="quantity"
                                      :value="$item->quantity"
                                      required />

                    </div>

                    <!-- BUTTON -->
                    <div class="flex justify-end">

                        <x-primary-button>
                            Update Quantity
                        </x-primary-button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>