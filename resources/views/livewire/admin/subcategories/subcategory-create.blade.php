<div>
    <form wire:submit="save">


        <div class="card-form">

            <x-validation-errors class="mb-4" />

            <div class="mb-4">
                <x-label>
                    Familias
                </x-label>

                <x-select class="w-full" wire:model.live="subcategory.family_id">
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
                <x-select name="category_id" class="w-full" wire:model.live="subcategory.category_id">
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
                <x-input class="w-full" placeholder="Ingrese el nombre de la categoría" wire:model="subcategory.name" />
            </div>
            <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>

        </div>
    </form>
</div>
