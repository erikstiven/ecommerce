<x-admin-layout
    :breadcrumbs="[
        ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['name' => 'Subcategorías', 'route' => route('admin.subcategories.index')],
    ]"
>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Subcategorías</h1>
        <a href="{{ route('admin.subcategories.create') }}" class="btn-admin btn-admin--primary">Nuevo</a>
    </div>

    @livewire('admin.subcategories.subcategory-table')
</x-admin-layout>
