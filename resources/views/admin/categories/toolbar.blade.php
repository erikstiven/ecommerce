<div class="flex items-center space-x-3" x-data>
    <button
        type="button"
        class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
        x-on:click="
            const runDelete = () => $wire.deleteSelected();
            if (typeof Swal === 'undefined') {
                if (confirm('¿Eliminar seleccionados?')) { runDelete(); }
                return;
            }
            Swal.fire({
                title: '¿Eliminar seleccionados?',
                text: 'Se eliminarán todos los elementos marcados.',
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
    >
        Eliminar seleccionados
    </button>
</div>
