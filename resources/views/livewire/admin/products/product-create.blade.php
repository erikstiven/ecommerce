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
            <img class="aspect-[16/9] object-cover object-center w-full"
                src="{{ $image ? $image->temporaryUrl() : asset('img/sin-imagen.jpg') }}" alt="">
        </figure>

        <x-validation-errors class="mb-4" />

        <div class="card">
            <div class="mb-4">
                <x-label class="mb-1">
                    Codigo
                </x-label>
                <x-input wire:model="product.sku" class="w-full" placeholder="Ingrese el código del producto">

                </x-input>
                <x-label class="mb-1">
                    Nombre
                </x-label>
                <x-input wire:model="product.name" class="w-full" placeholder="Ingrese el nombre del producto">
                </x-input>
            </div>
            <div class="mb-4">
                <x-label class="mb-1">
                    Descripción
                </x-label>
                <x-textarea wire:model="product.description" class="w-full"
                    placeholder="Ingrese la descripción del producto">
                </x-textarea>
            </div>
            <div class="mb-4">
                <x-label class="mb-1">
                    Familias
                </x-label>
                <x-select class="w-full" wire:model.live="family_id">
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

                <x-select class="w-full" wire:model.live="category_id">
                    <option value="" disabled selected>Seleccione una categoria</option>
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </x-select>

            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Subcategorias
                </x-label>

                <x-select class="w-full" wire:model.live="product.subcategory_id">
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
                <x-input type="number" wire:model="product.price" class="w-full" step="0.01"
                    placeholder="Ingrese el precio del producto">
                </x-input>

                <div class="flex justify-end mt-4">
                    <x-button wire:click="store" class="bg-blue-500 hover:bg-blue-600 text-white">
                        <i class="fas fa-save mr-2"></i>
                        Guardar
                    </x-button>

                </div>

            </div>
    </form>
</div>
