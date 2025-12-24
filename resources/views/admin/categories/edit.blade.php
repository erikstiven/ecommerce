<x-admin-layout :breadcrumbs="[
    [
        'name' => __('Dashboard'),
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Categorías',
        'route' => route('admin.categories.index'),
    ],
    [
        'name' => $category->name,
    ],
]">

    {{-- Formulario --}}
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-form">

            <x-validation-errors class="mb-4" />
            <div class="mb-4">
                <x-label>
                    Familia
                </x-label>
                <x-select name="family_id" class="w-full">
                    {{-- <option value="">Seleccione una familia</option> --}}
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}">{{ $family->name }}
                            @selected(old('family_id', $category->family_id == $family->id) == $family->id)</option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4">
                <x-label class="mt-2">
                    Nombre
                </x-label>
                <x-input class="w-full" placeholder="Ingrese el nombre de la categoría" name="name"
                    value="{{ old('name', $category->name) }}" />
            </div>
            <div class="flex justify-end">
                <x-danger-button type="button" onclick="confirmDelete()">
                    Eliminar
                </x-danger-button>
                <x-button class="ml-2">
                    Actualizar
                </x-button>
            </div>

        </div>
    </form>
    {{-- Fin Formulario --}}

     {{-- Eliminar categoria --}}
    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" id="delete-form" class="mt-4">
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
