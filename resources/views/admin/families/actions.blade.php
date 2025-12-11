<div class="flex items-center space-x-2" x-data>
    <a href="{{ route('admin.families.edit', $family) }}">
        <img src="{{ asset('img/icons/boligrafo.png') }}" class="w-6 h-6" alt="Editar">
    </a>

    <button type="button"
        x-on:click="
            const confirmDelete = () => $wire.deleteFamily({{ $family->id }});
            if (typeof Swal === 'undefined') {
                if (confirm('¿Deseas eliminar esta familia?')) { confirmDelete(); }
                return;
            }
            Swal.fire({
                title: '¿Eliminar familia?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
            }).then(result => {
                if (result.isConfirmed) {
                    confirmDelete();
                }
            });
        "
    >
        <img src="{{ asset('img/icons/eliminar.png') }}" class="w-6 h-6" alt="Eliminar">
    </button>
</div>
