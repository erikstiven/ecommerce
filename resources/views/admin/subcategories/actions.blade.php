<div class="flex items-center gap-2">
    <a
        href="{{ route('admin.subcategories.edit', $subcategory) }}"
        class="btn-admin btn-admin--ghost"
        title="Editar"
    >
        <img src="{{ asset('img/icons/boligrafo.png') }}" class="w-4 h-4" alt="Editar">
        <span class="sr-only">Editar</span>
    </a>

    <button
        type="button"
        class="btn-admin btn-admin--danger"
        x-data
        x-on:click="$dispatch('confirm-subcategory-delete', { id: {{ $subcategory->id }} })"
    >
        <img src="{{ asset('img/icons/eliminar.png') }}" class="w-4 h-4" alt="Eliminar">
        <span class="sr-only">Eliminar</span>
    </button>
</div>
