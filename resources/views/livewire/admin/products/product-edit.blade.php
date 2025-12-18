<div>

    <form wire:submit="store">
        <figure class="mb-4 relative">
            <div class="absolute top-8 right-8">
                <label
                    class="flex items-center px-4 py-2 rounded-lg bg-white shadow-md cursor-pointer text-gray-700 hover:bg-gray-100 transition-colors">
                    <i class="fas fa-camera mr-2"></i>
                    Actualizar Imagen
                    <input type="file" class="hidden" accept="image/*" wire:model="image">
                </label>
            </div>
            {{-- <img class="aspect-[16/9] object-cover object-center w-full"
                {{-- src="{{ $image ? $image->temporaryUrl() : Storage::url($productEdit['image_path']) }}" alt="" --}}
            {{-- src="{{ Storage::url('products/' . $productEdit['image_path']) }}" alt=""> --}}

            <img class="aspect-[16/9] object-cover object-center w-full"
                src="{{ $image ? $image->temporaryUrl() : $product->image }}" alt="Imagen del producto">

        </figure>

        <x-validation-errors class="mb-4" />

        <div class="card">
            <div class="mb-4">
                <x-label class="mb-1">
                    Codigo
                </x-label>
                <x-input wire:model="productEdit.sku" class="w-full" placeholder="Ingrese el código del producto">

                </x-input>
                <x-label class="mb-1">
                    Nombre
                </x-label>
                <x-input wire:model="productEdit.name" class="w-full" placeholder="Ingrese el nombre del producto">
                </x-input>
            </div>
            <div class="mb-4">
                <x-label class="mb-1">
                    Descripción
                </x-label>
                <x-textarea wire:model="productEdit.description" class="w-full"
                    placeholder="Ingrese la descripción del producto">
                </x-textarea>
            </div>
            <div class="mb-4">
                <x-label class="mb-1">
                    Familias
                </x-label>
                {{-- <x-select class="w-full" wire:model.live="family_id">
                    <option value="" disabled selected>Seleccione una familia</option>
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}">{{ $family->name }}</option>
                    @endforeach
                </x-select> --}}
                <x-select class="w-full" wire:model="family_id">
                    <option value="" disabled selected>Seleccione una familia</option>
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}">{{ $family->name }}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="mb-4">
                <x-label class="mb-1">
                    Categorias
                </x-label>

                {{-- <x-select class="w-full" wire:model.live="category_id">
                    <option value="" disabled selected>Seleccione una categoria</option>
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </x-select> --}}
                <x-select class="w-full" wire:model="category_id">
                    <option value="" disabled selected>Seleccione una categoría</option>
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </x-select>

            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Subcategorias
                </x-label>

                <x-select class="w-full" wire:model.live="productEdit.subcategory_id">
                    <option value="" disabled selected>Seleccione una subcategoria</option>
                    @foreach ($this->subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                    @endforeach
                </x-select>

            </div>
            <div class="mb-4">
                <x-label class="mb-1">
                    Precio
                </x-label>
                <x-input type="number" wire:model="productEdit.price" class="w-full" step="0.01"
                    placeholder="Ingrese el precio del producto">
                </x-input>
            </div>

            @if ($product->variants->count() == 0)
                <div class="mb-4">
                    <p class="text-sm text-gray-600">
                        Este producto no tiene variantes. Gestiona el stock desde el módulo de variantes para
                        mantener el inventario actualizado.
                    </p>
                </div>
            @endif


            <div class="flex justify-end mt-4">
                <x-danger-button type="button" onclick="confirmDelete()">
                    Eliminar
                </x-danger-button>


                <x-button class="ml-2">
                    Actualizar
                </x-button>
            </div>

    </form>

    {{-- Eliminar productos --}}
    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" id="delete-form" class="mt-4">
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
