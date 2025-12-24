<x-admin-layout :breadcrumbs="[
    [
        'name' => __('Dashboard'),
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Envios',
        'route' => route('admin.shipments.index'),
    ],
]">

    @livewire('admin.shipments.shipment-table')

</x-admin-layout>