<x-admin-layout :breadcrumbs="[
    [
        'name' => __('Dashboard'),
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Conductores',
        'route' => route('admin.drivers.index'),
    ],
]">

<x-slot name="action">

    <a href="{{ route('admin.drivers.create') }}" class="btn-gradient-blue">
        Nuevo
    </a>

</x-slot>

    @livewire('admin.drivers.driver-table')

</x-admin-layout>