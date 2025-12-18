<div class="flex items-center space-x-2">
    <a href="{{ route('admin.families.edit', $family) }}">
        <img src="{{ asset('img/icons/boligrafo.png') }}" class="w-6 h-6" alt="Editar">
    </a>

    <button wire:click="$dispatch('deleteFamily', { id: {{ $family->id }} })">
        <img src="{{ asset('img/icons/eliminar.png') }}" class="w-6 h-6" alt="Eliminar">
    </button>
</div>
