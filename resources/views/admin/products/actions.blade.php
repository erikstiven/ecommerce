<div class="flex items-center space-x-2">
    {{-- Botón para editar el producto --}}
    <a href="{{ route('admin.products.edit', $product) }}"
       class="text-blue-600 hover:text-blue-800 underline">
        Editar
    </a>

    {{-- Botón para ver detalles del producto --}}
    <a href="{{ route('admin.products.show', $product) }}"
       class="text-green-600 hover:text-green-800 underline">
        Ver
    </a>

    {{-- Botón para eliminar (puedes usar un formulario si es necesario) --}}
    <button type="button"
        class="text-red-600 hover:text-red-800 underline"
        wire:click="$emit('deleteProduct', {{ $product->id }})">
        Eliminar
    </button>
</div>
