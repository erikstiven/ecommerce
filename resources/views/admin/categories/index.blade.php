<x-admin-layout
    :breadcrumbs="[
        ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['name' => 'Categorías', 'route' => route('admin.categories.index')],
    ]"
>
    @livewire('admin.categories.category-table')
</x-admin-layout>
