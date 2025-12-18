<x-admin-layout
    :breadcrumbs="[
        ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['name' => 'Categorías', 'route' => route('admin.categories.index')],
    ]"
>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Categorías</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn-admin btn-admin--primary">Nuevo</a>
    </div>

    @livewire('admin.categories.category-table')
</x-admin-layout>
