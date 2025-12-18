<div class="flex items-center space-x-2">

    <a href="{{ route('admin.products.edit', $product) }}">
        <img src="{{ asset('img/icons/boligrafo.png') }}" class="w-6 h-6" alt="Editar">
    </a>

    <button wire:click="confirm('¿Eliminar el producto seleccionado? Esta acción no se puede deshacer.') && $dispatch('deleteProduct', { id: {{ $product->id }} })">
        <img src="{{ asset('img/icons/eliminar.png') }}" class="w-6 h-6" alt="Eliminar">
    </button>

</div>
