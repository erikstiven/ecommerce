<div class="flex items-center justify-center" x-data>
    <input
        type="checkbox"
        class="lw-header-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
        aria-label="Seleccionar todos"
        x-on:change="
            const checked = $event.target.checked;
            document.querySelectorAll('.lw-row-checkbox').forEach(cb => {
                cb.checked = checked;
                cb.dispatchEvent(new Event('change', { bubbles: true }));
            });
        "
    />
</div>
