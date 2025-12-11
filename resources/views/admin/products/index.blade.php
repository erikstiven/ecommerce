<x-admin-layout
    :breadcrumbs="[
        ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['name' => 'Productos', 'route' => route('admin.products.index')],
    ]"
>

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

            <a href="{{ route('admin.products.create') }}" class="btn-gradient-blue">
                Nuevo
            </a>
        </div>
    </x-slot>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <div class="flex flex-wrap items-center gap-2">
            <button
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md shadow hover:bg-gray-300 transition"
                wire:click="$emitTo('admin.products.product-table','toggleSelectAll')">
                Seleccionar todo
            </button>

            <button
                class="px-4 py-2 bg-red-600 text-white rounded-md shadow hover:bg-red-700 transition"
                wire:click="$emitTo('admin.products.product-table','deleteSelected')">
                Eliminar seleccionados
            </button>
        </div>
    </div>

    {{-- Renderiza la tabla dinámica de productos --}}
    @livewire('admin.products.product-table')
</x-admin-layout>

@push('js')
    <script>
        window.addEventListener('confirm-product-delete', event => {
            Swal.fire({
                title: '¿Eliminar producto?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
            }).then(result => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteProduct', { id: event.detail.id });
                }
            });
        });

        window.addEventListener('confirm-bulk-delete', () => {
            Swal.fire({
                title: '¿Eliminar seleccionados?',
                text: 'Se eliminarán todos los productos marcados.',
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
