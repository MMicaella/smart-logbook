<x-app-layout>

<x-slot name="header">
    <h2 class="text-xl font-bold">Custodian Overview</h2>
</x-slot>

<div class="py-10">

<div class="max-w-7xl mx-auto">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div class="bg-white p-6 shadow rounded text-center">
            <h4>Borrowed</h4>
            <h2 class="text-2xl font-bold">{{ $borrowed }}</h2>
        </div>

        <div class="bg-white p-6 shadow rounded text-center">
            <h4>Released</h4>
            <h2 class="text-2xl font-bold">{{ $released }}</h2>
        </div>

        <div class="bg-white p-6 shadow rounded text-center">
            <h4>Returned</h4>
            <h2 class="text-2xl font-bold">{{ $returned }}</h2>
        </div>

        <div class="bg-white p-6 shadow rounded text-center">
            <h4>Overdue</h4>
            <h2 class="text-2xl font-bold text-red-600">{{ $overdue }}</h2>
        </div>

    </div>

</div>

</div>

</x-app-layout>