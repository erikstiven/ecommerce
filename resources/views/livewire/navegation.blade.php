<div>
    {{-- HEADER DE LA PÁGINA --}}
    <header class="rounded-none md:rounded-lg bg-gradient-to-r from-[#3b0764] via-[#1e3a8a] to-[#7e22ce]">
        <x-container class="px-4 py-4">
            <div class="flex justify-between items-center space-x-8">
                <!-- Menú hamburguesa -->
                <button class="text-2xl md:text-3xl">
                    <i class="fas fa-bars text-white"></i>
                </button>

                <!-- Branding -->
                <h1>
                    <a href="/" class="inline-flex flex-col items-end text-right">
                        <span class="text-xl md:text-2xl font-semibold">Ecommerce</span>
                        <span class="text-xs opacity-80">Tienda online</span>
                    </a>
                </h1>

                <!-- Buscador (escritorio) -->
                <div class="flex-1 hidden md:block px-4">
                    <x-input
                        class="w-full rounded-lg bg-white/10 hover:bg-white/20 transition-colors duration-300 border-none text-white placeholder-white/60 px-4 py-2 text-sm backdrop-blur-sm"
                        placeholder="Buscar por producto, tienda o marca" />
                </div>

                <!-- Iconos de usuario y carrito -->
                <div class="flex items-center space-x-4 md:space-x-6">
                    <button class="text-xl">
                        <i class="fas fa-user text-white"></i>
                    </button>
                    <button class="text-xl">
                        <i class="fas fa-shopping-cart text-white"></i>
                    </button>

                    <!-- Botón WhatsApp -->
                    <a href="https://wa.me/593999999999" target="_blank"
                        class="flex items-center space-x-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 transition">
                        <i class="fab fa-whatsapp text-green-400 text-lg"></i>
                        <span class="hidden md:inline text-sm text-white font-medium">WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- Buscador (móvil) -->
            <div class="mt-4 md:hidden">
                <x-input
                    class="w-full rounded-lg bg-white/10 hover:bg-white/20 transition-colors duration-300 border-none text-white placeholder-white/60 px-4 py-2 text-sm backdrop-blur-sm"
                    placeholder="Buscar por producto, tienda o marca" />
            </div>
        </x-container>
    </header>

    <!-- Fondo oscuro (solo visible si el menú está abierto) -->
    <div class="fixed top-0 left-0 inset-0 bg-black opacity-25 z-10"></div>

    <!-- Menú lateral principal -->
    <div class="fixed top-0 left-0 z-20">
        <!-- Contenedor flex de los paneles -->
        <div class="flex">

            <!-- Panel izquierdo (categorías) -->
            <div class="w-screen md:w-80 h-screen bg-white">

                {{-- cabecera menú lateral --}}
                <div
                    class="h-[52px] flex items-center justify-between px-4 text-white font-semibold bg-gradient-to-r from-[#3b0764] via-[#1e3a8a] to-[#7e22ce]">
                    <span class="text-lg">Hola, {{ Auth::user()->name }}</span>
                    <button class="text-2xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- cuerpo menú lateral --}}
                <div class="h-[calc(100vh-52px)] overflow-auto">
                    <ul>
                        @foreach ($families as $family)
                            <li wire:mouseover="set('family_id', {{ $family->id }})"
                            class="border-b border-gray-100">
                                <a href="#"
                                    class="flex items-center justify-between px-4 py-4 text-gray-700 hover:bg-gray-100">
                                    <span>{{ $family->name }}</span>
                                    <i class="fa-solid fa-angle-right text-sm text-gray-400"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>

            <!-- Panel derecho perfectamente alineado -->
            <div class="w-80 xl:w-[57rem] pt-[52px] md:block">
                <div class="bg-white h-[calc(100vh-52px)] overflow-auto">
                    <!-- Contenido dinámico -->
                    {{-- {{ $slot }} --}}
                </div>
            </div>

        </div>
    </div>
</div>
