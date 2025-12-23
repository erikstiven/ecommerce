<x-admin-layout :breadcrumbs="[
    [
        'name' => __('Dashboard'),
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Subcategorías',
        'route' => route('admin.subcategories.index'),
    ],
]">
    <x-slot name="action">
        <a href="{{ route('admin.subcategories.create') }}" class="btn-gradient-blue">
            Nuevo
        </a>
    </x-slot>

    <livewire:admin.subcategories.subcategory-table />
</x-admin-layout>
