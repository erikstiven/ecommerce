<div class="space-y-4">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex flex-wrap items-center gap-3">
            <button
                type="button"
                class="inline-flex h-10 items-center gap-2 rounded-md border border-gray-300 bg-white px-3 text-sm font-medium text-gray-700 shadow-sm transition hover:border-red-300 hover:bg-red-50 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:cursor-not-allowed disabled:opacity-50"
                x-data
                x-on:click="
                    const runDelete = () => $wire.deleteSelected();
                    if (typeof Swal === 'undefined') {
                        if (confirm('¿Eliminar los productos seleccionados?')) { runDelete(); }
                        return;
                    }
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
                            runDelete();
                        }
                    });
                "
                @disabled(empty($selected))
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
                <span>Eliminar seleccionados</span>
            </button>
            <div class="flex h-10 items-center gap-2 rounded-md border border-gray-200 bg-gray-50 px-3 text-xs text-gray-700">
                <span class="font-medium">Seleccionados</span>
                <span class="rounded-md bg-white px-2 py-0.5 text-gray-900 shadow-inner">{{ count($selected) }}</span>
            </div>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:flex-wrap sm:items-center sm:justify-end sm:gap-3">
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 6.64 6.64a7.5 7.5 0 0 0 9.99 9.99Z" />
                    </svg>
                </div>
                <input
                    type="search"
                    wire:model.debounce.300ms="search"
                    placeholder="Buscar..."
                    class="h-10 w-56 rounded-md border border-gray-300 bg-white pl-9 pr-3 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div class="relative" x-data="{ open: false }" x-on:click.outside="open = false">
                <button
                    type="button"
                    class="inline-flex h-10 items-center gap-2 rounded-md border border-gray-300 bg-white px-3 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    x-on:click="open = !open"
                >
                    <span>Columnas</span>
                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                    </svg>
                </button>
                <div
                    x-cloak
                    x-show="open"
                    class="absolute right-0 z-20 mt-2 w-52 rounded-md border border-gray-200 bg-white p-3 shadow-lg"
                >
                    @foreach($visibleColumns as $key => $enabled)
                        <label class="flex items-center gap-2 py-1 text-sm text-gray-700">
                            <input type="checkbox" wire:click="toggleColumn('{{ $key }}')" @checked($enabled) class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="capitalize">{{ $key }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <label class="inline-flex h-10 items-center gap-2 rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-700 shadow-sm">
                <span>Filas</span>
                <select
                    wire:model="perPage"
                    class="h-8 rounded border border-gray-300 bg-white px-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                >
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </label>

            <a
                href="{{ route('admin.products.create') }}"
                class="inline-flex h-10 items-center gap-2 rounded-md bg-blue-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo
            </a>
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-12 px-3 py-2 text-center">
                        <input
                            type="checkbox"
                            wire:model.live="selectAll"
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >
                    </th>

                    @if($visibleColumns['id'])
                        <th class="px-3 py-2 text-left text-sm font-semibold text-gray-700">
                            <button type="button" class="flex items-center gap-1" wire:click="sortBy('id')">
                                <span>ID</span>
                                @if($sortField === 'id')
                                    <span class="text-xs">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </button>
                        </th>
                    @endif

                    @if($visibleColumns['sku'])
                        <th class="px-3 py-2 text-left text-sm font-semibold text-gray-700">
                            <button type="button" class="flex items-center gap-1" wire:click="sortBy('sku')">
                                <span>SKU</span>
                                @if($sortField === 'sku')
                                    <span class="text-xs">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </button>
                        </th>
                    @endif

                    @if($visibleColumns['name'])
                        <th class="px-3 py-2 text-left text-sm font-semibold text-gray-700">
                            <button type="button" class="flex items-center gap-1" wire:click="sortBy('name')">
                                <span>Nombre</span>
                                @if($sortField === 'name')
                                    <span class="text-xs">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </button>
                        </th>
                    @endif

                    @if($visibleColumns['price'])
                        <th class="px-3 py-2 text-left text-sm font-semibold text-gray-700">
                            <button type="button" class="flex items-center gap-1" wire:click="sortBy('price')">
                                <span>Precio</span>
                                @if($sortField === 'price')
                                    <span class="text-xs">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </button>
                        </th>
                    @endif

                    <th class="w-32 px-3 py-2 text-center text-sm font-semibold text-gray-700">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center">
                            <input
                                type="checkbox"
                                value="{{ $product->id }}"
                                wire:model.live="selected"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                        </td>

                        @if($visibleColumns['id'])
                            <td class="px-3 py-2 text-sm text-gray-700">{{ $product->id }}</td>
                        @endif

                        @if($visibleColumns['sku'])
                            <td class="px-3 py-2 text-sm text-gray-700">{{ $product->sku }}</td>
                        @endif

                        @if($visibleColumns['name'])
                            <td class="px-3 py-2 text-sm text-gray-700">{{ $product->name }}</td>
                        @endif

                        @if($visibleColumns['price'])
                            <td class="px-3 py-2 text-sm font-semibold text-gray-800">${{ number_format($product->price, 2) }}</td>
                        @endif

                        <td class="px-3 py-2 text-center">
                            @include('admin.products.actions', ['product' => $product])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-3 py-6 text-center text-sm text-gray-500">No hay productos para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-3 text-sm text-gray-600">
        <div>
            Mostrando {{ $products->firstItem() }} - {{ $products->lastItem() }} de {{ $products->total() }} productos
        </div>
        <div>
            {{ $products->links() }}
        </div>
    </div>
</div>
