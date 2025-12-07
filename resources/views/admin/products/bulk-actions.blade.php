<div class="flex items-center gap-3">
    <button
        type="button"
        wire:click="deleteSelected"
        class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-md shadow disabled:opacity-50 disabled:cursor-not-allowed hover:bg-red-700 transition"
        @disabled(!$this->hasSelected)
    >
        Eliminar seleccionados
    </button>
</div>
