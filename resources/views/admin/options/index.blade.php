    <x-admin-layout :breadcrumbs="[
    [
        'name' => __('ui.dashboard'),
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Opciones'
    ],
]">

@livewire('admin.options.manage-options')

</x-admin-layout>