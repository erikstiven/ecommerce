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
        'name' => 'Nuevo',
    ],
]">

    {{-- Formulario --}}
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="card-form">

            <x-validation-errors class="mb-4" />
            <div class="mb-4">
                <x-label>
                    Familia
                </x-label>
                <x-select name="family_id" class="w-full">
                    {{-- <option value="">Seleccione una familia</option> --}}
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}" @selected(old('family_id') == $family->id)>
                            {{ $family->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4">
                <x-label class="mt-2">
                    Nombre
                </x-label>
                <x-input class="w-full" placeholder="Ingrese el nombre de la categoría" name="name"
                    value="{{ old('name') }}" />
            </div>
            <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>

        </div>
    </form>
    {{-- Fin Formulario --}}

</x-admin-layout>
