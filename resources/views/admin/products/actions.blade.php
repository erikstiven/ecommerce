<div class="flex items-center justify-center space-x-2" x-data>
    <a
        href="{{ route('admin.products.edit', $product) }}"
        class="p-1 text-gray-600 transition rounded hover:bg-blue-50 hover:text-blue-700"
        title="Editar producto"
    >
        <img src="{{ asset('img/icons/boligrafo.png') }}" class="w-5 h-5" alt="Editar producto">
    </a>

    <button
        type="button"
        class="p-1 text-gray-600 transition rounded hover:bg-red-50 hover:text-red-700"
        title="Eliminar producto"
        x-on:click="
            const confirmDelete = () => $wire.deleteProduct({{ $product->id }});
            if (typeof Swal === 'undefined') {
                if (confirm('¿Deseas eliminar este producto?')) { confirmDelete(); }
                return;
            }
            Swal.fire({
                title: '¿Eliminar producto?',
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
        <img src="{{ asset('img/icons/eliminar.png') }}" class="w-5 h-5" alt="Eliminar producto">
    </button>
</div>
