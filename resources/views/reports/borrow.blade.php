<x-app-layout>

<x-slot name="header">
    <h2 class="text-2xl text-white font-bold">
        Borrow Analytics
    </h2>
</x-slot>

<div class="p-6 text-white">

    <h3 class="mb-4">Monthly Borrow Records</h3>

    <table class="w-full">
        <thead>
            <tr>
                <th>User</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
            @foreach($borrows as $borrow)
            <tr>
                <td>{{ $borrow->user->name }}</td>
                <td>{{ $borrow->item->item_name }}</td>
                <td>{{ $borrow->quantity }}</td>
                <td>{{ $borrow->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

</x-app-layout>