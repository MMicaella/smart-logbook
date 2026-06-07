<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white">
            Item Management
        </h2>
    </x-slot>

    <div class="p-6">

        <!-- ADD BUTTON -->
        <a href="/custodian/items/create"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            + Add Item
        </a>

        <!-- TABLE -->
        <div class="mt-5 bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">

            <table class="w-full text-left">

                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="p-4">ID</th>
                        <th class="p-4">Item Name</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Quantity</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($items as $item)

                    <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">

                        <td class="p-4">
                            {{ $item->id }}
                        </td>

                        <td class="p-4 font-medium">
                            {{ $item->item_name }}
                        </td>

                        <td class="p-4">
                            {{ $item->category }}
                        </td>

                        <td class="p-4">
                            {{ $item->quantity }}
                        </td>

                        <td class="p-4">

                            @if($item->quantity <= 0)

                                <span class="text-red-600 font-bold">
                                    Unavailable
                                </span>

                            @elseif($item->quantity <= 5)

                                <span class="text-yellow-500 font-bold">
                                    Low Stock
                                </span>

                            @else

                                <span class="text-green-600 font-bold">
                                    Available
                                </span>

                            @endif

                        </td>

                        <td class="p-4 flex gap-2">

                            <!-- EDIT -->
                            <a href="/custodian/items/{{ $item->id }}/edit"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                Update Qty
                            </a>

                            <!-- DELETE -->
                            <form action="/custodian/items/{{ $item->id }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>