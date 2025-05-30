<div>
    <form wire:submit="save">


        <div class="card-form">

            <x-validation-errors class="mb-4" />

            <div class="mb-4">
                <x-label>
                    Familias
                </x-label>

                <x-select class="w-full" wire:model.live="subcategoryEdit.family_id">
                    <option value="" disabled>
                        Seleccione una familia
                    </option>
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}" @selected(old('family_id') == $family->id)>
                            {{ $family->name }}</option>
                    @endforeach

                </x-select>

            </div>

            <div class="mb-4">
                <x-label>
                    Categoría
                </x-label>
                <x-select name="category_id" class="w-full" wire:model.live="subcategoryEdit.category_id">
                    <option value="" disabled>
                        Seleccione una categoría
                    </option>

                    {{-- <option value="">Seleccione una familia</option> --}}
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4">
                <x-label class="mt-2">
                    Nombre
                </x-label>
                <x-input class="w-full" placeholder="Ingrese el nombre de la categoría"
                    wire:model="subcategoryEdit.name" />
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

    {{-- Eliminar subcategoria --}}
    <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST" id="delete-form"
        class="mt-4">
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
</div>
