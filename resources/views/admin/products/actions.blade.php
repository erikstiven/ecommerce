<div class="flex items-center space-x-2">
    {{-- Botón para editar el producto --}}
    <a href="{{ route('admin.products.edit', $product) }}"
        class="inline-flex items-center justify-center rounded-md p-1 text-blue-600 hover:text-blue-800">
        <i data-lucide="pencil" class="w-4 h-4"></i>
        <span class="sr-only">Editar</span>
    </a>

    {{-- Botón para ver detalles del producto
    <a href="{{ route('admin.products.show', $product) }}"
       class="inline-flex items-center justify-center rounded-md p-1 text-green-600 hover:text-green-800">
        <i data-lucide="eye" class="w-4 h-4"></i>
        <span class="sr-only">Ver</span>
    </a> --}}

    {{-- Botón para eliminar --}}
    <button wire:click="$dispatch('deleteProduct', { id: {{ $product->id }} })"
        class="inline-flex items-center justify-center rounded-md p-1 text-red-600 hover:text-red-800">
        <i data-lucide="trash-2" class="w-4 h-4"></i>
        <span class="sr-only">Eliminar</span>
    </button>


</div>
