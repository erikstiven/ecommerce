<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
    ],
]">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                    alt="{{ Auth::user()->name }}" />
                <div class="ml-4 flex-1">
                    <h2 class="text-lg font-semibold">Bienvenido, {{ Auth::user()->name }}</h2>

                    {{-- Cerrar sesión --}}
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-1 px-3 py-1 bg-red-600 text-white text-xs font-medium rounded shadow-sm hover:bg-red-700 transition duration-200">
                            <span>Cerrar sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-center">
            <h2 class="text-xl font-semibold">
                Nombre Empresa
            </h2>
        </div>
    </div>

</x-admin-layout>
