<div class="datatable-toolbar datatable-toolbar-right">
    <div class="flex flex-wrap items-center justify-end gap-3 w-full">
        <div class="dt-search">
            <span class="dt-search-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                    <circle cx="11" cy="11" r="7"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </span>
            <input
                type="search"
                placeholder="Buscar"
                class="dt-input"
                wire:model.live.debounce.400ms="search"
            />
        </div>

        <div class="dt-actions flex items-center gap-2">
            <button type="button" class="dt-btn dt-btn-outline">
                Columnas
            </button>
        </div>

        <div class="dt-length flex items-center gap-2">
            <label class="text-sm font-medium text-gray-600">Mostrar</label>
            <select
                wire:model.live="perPage"
                class="dt-select"
            >
                @foreach([10, 25, 50, 100] as $size)
                    <option value="{{ $size }}">{{ $size }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
