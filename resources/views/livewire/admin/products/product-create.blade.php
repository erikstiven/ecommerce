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
        <x-textarea wire:model="product.description" class="w-full" placeholder="Ingrese la descripción del producto">
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

        <x-select class="w-full" wire:model="family_id">
            <option value="" disabled selected>Seleccione una categoria</option>
            @foreach ($this->categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </x-select>

    </div>
</div>
