<div class="datatable-toolbar datatable-toolbar-left" x-data>
    <div class="flex items-center gap-2 flex-wrap">
        <button type="button" class="dt-btn dt-btn-outline" aria-label="Reordenar">
            Reordenar
        </button>

        <button
            type="button"
            class="dt-btn dt-btn-outline"
            wire:click="toggleSelectAll"
        >
            Seleccionar todo
        </button>

        <button
            type="button"
            class="dt-btn dt-btn-danger"
            x-on:click="$dispatch('confirm-bulk-delete')"
            @if(empty($this->selected)) disabled @endif
        >
            Acciones masivas
        </button>

        <button
            type="button"
            class="dt-btn dt-btn-outline"
            x-on:click="$dispatch('toggle-filters')"
        >
            Filtros
        </button>
    </div>
</div>
