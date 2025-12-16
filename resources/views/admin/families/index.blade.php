<x-admin-layout
    :breadcrumbs="[
        ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['name' => 'Familias', 'route' => route('admin.families.index')],
    ]"
>
    @livewire('admin.families.family-table')
</x-admin-layout>
