<input
    type="checkbox"
    class="lw-row-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
    value="{{ $row->id }}"
    wire:key="row-checkbox-{{ $row->id }}"
    wire:model.live="selected"
/>
