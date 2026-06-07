<x-app-layout>

<x-slot name="header">
    <div class="glass-header">
        <h2 class="text-2xl font-bold text-white">
            Reports & Analytics
        </h2>
    </div>
</x-slot>

<div class="grid md:grid-cols-3 gap-6 p-6">

    <a href="/reports/borrows" class="glass rounded-2xl p-6 text-white">
        📦 Borrow Reports
    </a>

    <a href="/reports/bookings" class="glass rounded-2xl p-6 text-white">
        🚗 Booking Reports
    </a>

    <a href="/reports/requests" class="glass rounded-2xl p-6 text-white">
        📥 Request Reports
    </a>

</div>

</x-app-layout>