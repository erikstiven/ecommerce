<x-admin-layout :breadcrumbs="[
    ['name' => __('Dashboard'), 'route' => route('admin.dashboard')],
    ['name' => 'Conductores', 'route' => route('admin.drivers.index')],
    ['name' => 'Nuevo'],
]">

<div class="bg-white rounded-lg shadow-lg p-6">

    <!-- Mostrar errores de validación -->
    <x-validation-errors class="mb-4" />

    <form action="{{ route('admin.drivers.store') }}" method="POST">
        @csrf

        <!-- Selección de usuario -->
        <div class="mb-4">
            <x-label for="user_id" class="mb-1">Usuario</x-label>

            <x-select class="w-full" name="user_id" id="user_id">
                <option value="" disabled selected>Seleccione un usuario</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected($user->id == old('user_id'))>
                        {{ $user->name }}
                    </option>
                @endforeach
            </x-select>
        </div>

        <!-- Tipo de unidad y placa -->
        <div class="grid grid-cols-2 gap-4 mb-4">

            <!-- Tipo de unidad -->
            <div>
                <x-label for="type" class="mb-1">Tipo de unidad</x-label>

                <x-select class="w-full" name="type" id="type">
                    <option value="1" @selected(old('type') == 1)>Moto</option>
                    <option value="2" @selected(old('type') == 2)>Auto</option>
                </x-select>
            </div>

            <!-- Placa de la unidad -->
            <div>
                <x-label for="plate_number" class="mb-1">Placa de la unidad</x-label>

                <x-input
                    class="w-full"
                    name="plate_number"
                    id="plate_number"
                    value="{{ old('plate_number') }}"
                    placeholder="Ingrese la placa de la unidad" />
            </div>

        </div>

        <!-- Botón Guardar -->
        <div class="flex justify-end">
            <x-button>Guardar</x-button>
        </div>

    </form>

</div>

</x-admin-layout>
