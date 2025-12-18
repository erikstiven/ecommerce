<div class="flex items-center space-x-2">
    <a href="{{ route('admin.categories.edit', $category) }}">
        <img src="{{ asset('img/icons/boligrafo.png') }}" class="w-6 h-6" alt="Editar">
    </a>

    <button wire:click="confirm('¿Eliminar la categoría seleccionada? Esta acción no se puede deshacer.') && $dispatch('deleteCategory', { id: {{ $category->id }} })">
        <img src="{{ asset('img/icons/eliminar.png') }}" class="w-6 h-6" alt="Eliminar">
    </button>
</div>
