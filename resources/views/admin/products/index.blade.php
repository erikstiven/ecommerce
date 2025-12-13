<x-admin-layout
    :breadcrumbs="[
        ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['name' => 'Productos', 'route' => route('admin.products.index')],
    ]"
>

    {{-- Renderiza la tabla dinámica de productos --}}
    @livewire('admin.products.product-table')
</x-admin-layout>
