<x-admin-layout
    :breadcrumbs="[
        ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['name' => 'Familias', 'route' => route('admin.families.index')],
    ]"
>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Familias</h1>
        <a href="{{ route('admin.families.create') }}" class="btn-admin btn-admin--primary">Nuevo</a>
    </div>

    @livewire('admin.families.family-table')
</x-admin-layout>
