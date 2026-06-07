<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl">
        My Dashboard
    </h2>
</x-slot>

<div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded shadow text-center">
        <h4>My Borrows</h4>
        <h2 class="text-2xl font-bold">{{ $borrowCount }}</h2>
    </div>

    <div class="bg-white p-6 rounded shadow text-center">
        <h4>My Bookings</h4>
        <h2 class="text-2xl font-bold">{{ $bookingCount }}</h2>
    </div>

    <div class="bg-white p-6 rounded shadow text-center">
        <h4>Pending Requests</h4>
        <h2 class="text-2xl font-bold">{{ $pendingCount }}</h2>
    </div>

</div>

</x-app-layout>