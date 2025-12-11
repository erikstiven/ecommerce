<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Subcategorías',
        'route' => route('admin.subcategories.index'),
    ],
]">

    <x-slot name="action">
        <div
            x-data="{ selectedCount: 0 }"
            x-on:selection-updated.window="selectedCount = $event.detail.count"
            class="flex items-center gap-3"
        >
            <button
                type="button"
                class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-md shadow disabled:opacity-50 disabled:cursor-not-allowed hover:bg-red-700 transition"
                :disabled="selectedCount === 0"
                x-on:click="$dispatch('confirm-bulk-delete')"
            >
                Eliminar seleccionados
            </button>

            <a href="{{ route('admin.subcategories.create') }}" class="btn-gradient-blue">
                Nuevo
            </a>
        </div>
    </x-slot>

    @livewire('admin.subcategories.subcategory-table')
</x-admin-layout>

@push('js')
    <script>
        window.addEventListener('confirm-subcategory-delete', event => {
            Swal.fire({
                title: '¿Eliminar subcategoría?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
            }).then(result => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteSubcategory', { id: event.detail.id });
                }
            });
        });

        window.addEventListener('confirm-bulk-delete', () => {
            Swal.fire({
                title: '¿Eliminar seleccionados?',
                text: 'Se eliminarán todos los elementos marcados.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
            }).then(result => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteSelected');
                }
            });
        });
    </script>
@endpush
