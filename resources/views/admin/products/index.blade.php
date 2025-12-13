<x-admin-layout
    :breadcrumbs="[
        ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['name' => 'Productos', 'route' => route('admin.products.index')],
    ]"
>

    <x-slot name="action">
        <a href="{{ route('admin.products.create') }}" class="btn-gradient-blue">
            Nuevo
        </a>
    </x-slot>

    {{-- Renderiza la tabla dinámica de productos --}}
    @livewire('admin.products.product-table')
</x-admin-layout>
