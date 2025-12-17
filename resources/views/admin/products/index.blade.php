<x-admin-layout
    :breadcrumbs="[
        ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['name' => 'Productos', 'route' => route('admin.products.index')],
    ]"
>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Productos</h1>
        <a href="{{ route('admin.products.create') }}" class="btn-admin btn-admin--primary">Nuevo</a>
    </div>

    @livewire('admin.products.product-table')
</x-admin-layout>
