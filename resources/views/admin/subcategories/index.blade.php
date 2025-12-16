<x-admin-layout
    :breadcrumbs="[
        ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['name' => 'Subcategorías', 'route' => route('admin.subcategories.index')],
    ]"
>
    @livewire('admin.subcategories.subcategory-table')
</x-admin-layout>
