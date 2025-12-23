<x-admin-layout :breadcrumbs="[
    [
        'name' => __('Dashboard'),
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Familias',
        'route' => route('admin.families.index'),
    ],
    [
        'name' => $family->name,
    ],
]">

    {{-- Formulario --}}
    <div class="card-form">
        <form action="{{ route('admin.families.update', $family) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <x-label class="mt-2">
                    Nombre
                </x-label>
                <x-input class="w-full" placeholder="Ingrese el nombre de la familia" name="name"
                    value="{{ old('name', $family->name) }}" />
            </div>
            <div class="flex justify-end">
                <x-danger-button type="button" onclick="confirmDelete()">
                    Eliminar
                </x-danger-button>


                <x-button class="ml-2">
                    Actualizar
                </x-button>
            </div>
        </form>

    </div>
    {{-- Eliminar familia --}}
    <form action="{{ route('admin.families.destroy', $family) }}" method="POST" id="delete-form" class="mt-4">
        @csrf
        @method('DELETE')
    </form>

    @push('js')
        <script>
            function confirmDelete() {
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form').submit();
                    }
                });
            }
        </script>
    @endpush

</x-admin-layout>
