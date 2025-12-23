<x-admin-layout :breadcrumbs="[
    [
        'name' => __('ui.dashboard'),
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Conductores',
        'route' => route('admin.drivers.index'),
    ],
]">

</x-admin-layout>