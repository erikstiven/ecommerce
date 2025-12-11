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
        <a href="{{ route('admin.subcategories.create') }}" class="btn-gradient-blue">
            Nuevo
        </a>
    </x-slot>

    @if ($subcategories->count())

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
                            class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 tracking-widest uppercase">
                            Categoría
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 tracking-widest uppercase">
                            Familia
                        </th>
                        <th
                            class="px-6 py-4 text-right text-xs font-bold text-gray-600 dark:text-gray-300 tracking-widest uppercase">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($subcategories as $subcategory)
                        <tr class="group hover:bg-blue-50 dark:hover:bg-gray-800 transition duration-200">
                            <td
                                class="px-6 py-4 text-sm font-semibold text-gray-700 dark:text-gray-200 group-hover:text-blue-600">
                                {{ $subcategory->id }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 group-hover:text-blue-600">
                                {{ $subcategory->name }}
                            </td>
                             <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 group-hover:text-blue-600">
                                {{ $subcategory->category->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 group-hover:text-blue-600">
                                {{ $subcategory->category->family->name }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('admin.subcategories.edit', $subcategory) }}"
                                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-md bg-blue-500 text-white text-xs font-medium shadow hover:bg-blue-600 hover:scale-105 transition-all duration-200">
                                        <i data-lucide="pencil" class="w-4 h-4"></i> Editar
                                    </a>

                                    <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST"
                                        onsubmit="return confirm('¿Deseas eliminar esta subcategoría?');">
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
