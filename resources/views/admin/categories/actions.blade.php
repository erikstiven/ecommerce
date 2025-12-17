<div class="flex items-center space-x-2" x-data>
    <a href="{{ route('admin.categories.edit', $category) }}">
        <img src="{{ asset('img/icons/boligrafo.png') }}" class="w-6 h-6" alt="Editar">
    </a>

    <button type="button"
        x-on:click="
            const confirmDelete = () => $wire.deleteCategory({{ $category->id }});
            if (typeof Swal === 'undefined') {
                if (confirm('¿Deseas eliminar esta categoría?')) { confirmDelete(); }
                return;
            }
            Swal.fire({
                title: '¿Eliminar categoría?',
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
