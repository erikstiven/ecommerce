<div
    class="flex items-center space-x-3"
    x-data="{ allChecked: false, selectedCount: 0 }"
    x-on:selection-updated.window="selectedCount = $event.detail.count"
>
    <label class="inline-flex items-center space-x-2 text-sm font-medium text-gray-700">
        <input
            type="checkbox"
            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
            x-model="allChecked"
            x-on:change="
                const checked = $event.target.checked;
                document.querySelectorAll('.lw-row-checkbox').forEach(cb => {
                    cb.checked = checked;
                    cb.dispatchEvent(new Event('change', { bubbles: true }));
                });
            "
        >
        <span>Seleccionar todo</span>
    </label>

    <button
        type="button"
        class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 disabled:opacity-50 disabled:cursor-not-allowed"
        x-on:click="
            const runDelete = () => $wire.deleteSelected();
            if (typeof Swal === 'undefined') {
                if (confirm('¿Eliminar seleccionados?')) { runDelete(); }
                return;
            }
            Swal.fire({
                title: '¿Eliminar seleccionados?',
                text: 'Se eliminarán todos los productos marcados.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
            }).then(result => {
                if (result.isConfirmed) {
                    runDelete();
                }
            });
        "
        x-bind:disabled="selectedCount === 0"
    >
        Eliminar seleccionados
    </button>
</div>
