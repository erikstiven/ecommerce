<x-admin-layout :breadcrumbs="[
    [
        'name' => __('Dashboard'),
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Categorías',
        'route' => route('admin.categories.index'),
    ],
]">
    <x-slot name="action">
        <a href="{{ route('admin.categories.create') }}" class="btn-gradient-blue">
            Nuevo
        </a>
    </x-slot>

    <livewire:admin.categories.category-table />
</x-admin-layout>
