<x-admin-layout :breadcrumbs="[
    [
        'name' => __('Dashboard'),
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Familias',
        'route' => route('admin.families.index'),
    ],
]">
    <x-slot name="action">
        <a href="{{ route('admin.families.create') }}" class="btn-gradient-blue">
            Nuevo
        </a>
    </x-slot>

    <livewire:admin.families.family-table />
</x-admin-layout>
