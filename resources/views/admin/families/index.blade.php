<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Familias',
        'route' => route('admin.families.index'),
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

    @if ($families->count())

        <div class="overflow-x-auto rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                    <tr>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 tracking-widest uppercase">
                            ID
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 tracking-widest uppercase">
                            Nombre
                        </th>
                        <th
                            class="px-6 py-4 text-right text-xs font-bold text-gray-600 dark:text-gray-300 tracking-widest uppercase">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($families as $family)
                        <tr class="group hover:bg-blue-50 dark:hover:bg-gray-800 transition duration-200">
                            <td
                                class="px-6 py-4 text-sm font-semibold text-gray-700 dark:text-gray-200 group-hover:text-blue-600">
                                {{ $family->id }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 group-hover:text-blue-600">
                                {{ $family->name }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('admin.families.edit', $family) }}"
                                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-md bg-blue-500 text-white text-xs font-medium shadow hover:bg-blue-600 hover:scale-105 transition-all duration-200">
                                        <i data-lucide="pencil" class="w-4 h-4"></i> Editar
                                    </a>

                                    <form action="{{ route('admin.families.destroy', $family) }}" method="POST"
                                        onsubmit="return confirm('¿Deseas eliminar esta familia?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-4 py-1.5 rounded-md bg-red-500 text-white text-xs font-medium shadow hover:bg-red-600 hover:scale-105 transition-all duration-200">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>

    @livewire('admin.families.family-table')
</x-admin-layout>

@push('js')
    <script>
        window.addEventListener('confirm-family-delete', event => {
            Swal.fire({
                title: '¿Eliminar familia?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
            }).then(result => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteFamily', { id: event.detail.id });
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
