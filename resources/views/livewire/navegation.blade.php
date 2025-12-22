<div x-data="{ open: false }">

    {{-- HEADER DE LA PÁGINA --}}
    <header class="rounded-none bg-gradient-to-r from-[#3b0764] via-[#1e3a8a] to-[#7e22ce]">
        <x-container class="px-4 py-4">
            <div class="flex justify-between items-center space-x-8">

                <!-- Grupo: Hamburguesa + Logo (móvil) / Solo Hamburguesa (escritorio) -->
                <div class="flex items-center space-x-4">
                    <!-- Menú hamburguesa -->
                    <button class="text-2xl md:text-3xl pointer-events-auto" x-on:click="open = true">
                        <i class="fas fa-bars text-white"></i>
                    </button>

                    <!-- Logo móvil (aparece solo en móvil, a la derecha de la hamburguesa) -->
                    <div class="md:hidden">
                        <a href="/" class="pointer-events-auto">
                            <h2 class="text-xl font-bold text-white">HMB Sports</h2>
                        </a>
                    </div>
                </div>

                <!-- Logo escritorio (centrado, solo visible en desktop) -->
                <h1 class="hidden md:block">
                    <div class="flex justify-center md:justify-start">
                        <a href="/" class="pointer-events-auto">
                            <h2 class="text-2xl font-bold text-white md:text-3xl">HMB Sports</h2>
                        </a>
                    </div>
                </h1>

                <!-- Buscador (escritorio) -->
                <div class="flex-1 hidden md:block px-4">
                    <x-input onkeypress="handleEnter(event)" oninput="search(this.value)"
                        class="w-full rounded-lg bg-white/10 hover:bg-white/20 transition-colors duration-300 border-none text-white placeholder-white/60 px-4 py-2 text-sm backdrop-blur-sm pointer-events-auto"
                        placeholder="Buscar por producto, tienda o marca" />
                </div>

                <!-- Iconos -->
                <div class="flex items-center space-x-4 md:space-x-6">

                    <x-dropdown>

                        <x-slot name="trigger">

                            @auth
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition pointer-events-auto">
                                    <img class="size-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <button class="text-xl pointer-events-auto">
                                    <i class="fas fa-user text-white"></i>
                                </button>
                            @endauth

                        </x-slot>

                        <x-slot name="content">

                            @guest

                                <div class="px-4 py-2">

                                    <div class="flex justify-center">

                                        <a href="{{ route('login') }}" class="btn btn-gradient-purple pointer-events-auto">
                                            Iniciar Sesión
                                        </a>

                                    </div>

                                    <p class="text-sm text-center mt-2">

                                        ¿No tienes una cuenta? <a href="{{ route('register') }}"
                                            class="text-purple-600 hover:underline mt-2 pointer-events-auto">Registrate</a>


                                    </p>

                                </div>
                            @else
                                <x-dropdown-link href="{{ route('profile.show') }}">

                                    Mi Perfil

                                </x-dropdown-link>

                                <div class="border-t border-gray-200">

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                            {{ __('Cerrar Sesión') }}
                                        </x-dropdown-link>
                                    </form>

                                </div>

                            @endguest

                        </x-slot>

                    </x-dropdown>

                    <a href="{{ route('cart.index') }}" class="relative pointer-events-auto">
                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                        <span id="cart-count"
                            class="absolute -top-2 -end-4 inline-flex items-center justify-center w-6 h-6 bg-red-500 rounded-full text-xs font-bold text-white">
                            {{ Cart::instance('shopping')->count() }}
                        </span>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/593999999999" target="_blank"
                        class="flex items-center space-x-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 transition pointer-events-auto">
                        <i class="fab fa-whatsapp text-green-400 text-lg"></i>
                        <span class="hidden md:inline text-sm text-white font-medium">WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- Buscador (móvil) -->
            <div class="mt-4 md:hidden">
                <x-input onkeypress="handleEnter(event)" oninput="search(this.value)"
                    class="w-full rounded-lg bg-white/10 hover:bg-white/20 transition-colors duration-300 border-none text-white placeholder-white/60 px-4 py-2 text-sm backdrop-blur-sm pointer-events-auto"
                    placeholder="Buscar por producto, tienda o marca" />

            </div>
        </x-container>
    </header>

    <!-- Menú lateral con sombra -->
    <div x-show="open" x-transition.opacity x-cloak class="fixed inset-0 z-50">

        <!-- Fondo oscuro (sombra) que cierra el panel -->
        <div class="absolute inset-0 bg-black/50 z-40 pointer-events-auto" x-on:click="open = false"></div>

        <!-- Paneles contenido -->
        <div class="relative z-50 flex h-full w-full pointer-events-none">

            <!-- Panel izquierdo -->
            <div class="w-full md:w-80 h-screen bg-white flex-shrink-0 pointer-events-auto" x-on:click.stop>
                <div
                    class="h-[52px] flex items-center justify-between px-4 text-white font-semibold bg-gradient-to-r from-[#3b0764] via-[#1e3a8a] to-[#7e22ce]">
                    <span class="text-lg">
                        @auth
                            Hola, {{ Auth::user()->name }}
                        @else
                            Hola, Invitado
                        @endauth
                    </span>
                    <button class="text-2xl" x-on:click="open = false">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="h-[calc(100vh-52px)] overflow-auto">
                    <ul>
                        @forelse ($families as $family)
                            <li wire:mouseover="set('family_id', {{ $family->id }})"
                                class="border-b border-gray-100">
                                @if ($family?->getKey())
                                    <a href="{{ route('families.show', $family) }}"
                                        class="flex items-center justify-between px-4 py-4 text-gray-700 hover:bg-gray-100">
                                        <span>{{ $family->name }}</span>
                                        <i class="fa-solid fa-angle-right text-sm text-gray-400"></i>
                                    </a>
                                @else
                                    <div class="flex items-center justify-between px-4 py-4 text-gray-700">
                                        <span>{{ $family->name ?? 'Familia' }}</span>
                                        <i class="fa-solid fa-angle-right text-sm text-gray-400"></i>
                                    </div>
                                @endif
                            </li>
                        @empty
                            <li class="px-4 py-6 text-sm text-gray-500">
                                No hay familias disponibles.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Panel derecho (solo escritorio) -->
            <div class="hidden md:block pointer-events-auto">
                <div class="w-[600px] lg:w-[800px] xl:w-[900px] bg-white h-[calc(100vh-52px)] overflow-auto px-6 py-8 mt-[52px]"
                    x-on:click.stop>
                    <div class="mb-8 flex justify-between items-center">
                        <p class="border-b-[3px] border-purple-600 uppercase text-xl font-semibold pb-1">
                            {{ $this->familyName }}
                        </p>
                        @if ($family_id)
                            <a href="{{ route('families.show', $family_id) }}" class="btn btn-gradient-purple">Ver todo</a>
                        @endif
                    </div>

                    <ul class="grid w-full grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                        @foreach ($this->categories as $category)
                            <li>
                                <a href="{{ route('categories.show', $category) }}"
                                    class="text-purple-600 font-semibold text-base md:text-lg">
                                    {{ $category->name }}
                                </a>
                                <ul class="mt-3 space-y-2">
                                    @foreach ($category->subcategories as $subcategory)
                                        <li>
                                            <a href="{{ route('subcategories.show', $subcategory) }}"
                                                class="text-sm text-gray-700 hover:text-purple-600">
                                                {{ $subcategory->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>

    @push('js')
        <script>
            // Actualiza el contador del carrito cuando Livewire emite el evento cartUpdated
            Livewire.on('cartUpdated', (count) => {
                document.getElementById('cart-count').innerHTML = count;
            });

            // Envía el término de búsqueda a cualquier componente Livewire que escuche el evento 'search'
            function search(value) {
                Livewire.dispatch('search', {
                    search: value
                });
            }

            // Redirige a la página de búsqueda al pulsar Enter
            function handleEnter(event) {
                const value = event.target.value.trim();
                if (event.key === 'Enter' && value !== '') {
                    window.location.href = "{{ route('search') }}?search=" + encodeURIComponent(value);
                }
            }

            // Bloquear clics de PPC/ads en elementos específicos
            document.addEventListener('DOMContentLoaded', function() {
                // Prevenir que scripts externos modifiquen elementos clickeables
                const protectedElements = document.querySelectorAll('.pointer-events-auto');
                
                protectedElements.forEach(element => {
                    element.addEventListener('click', function(e) {
                        // Solo permitir clics legítimos del usuario
                        if (!e.isTrusted) {
                            e.preventDefault();
                            e.stopPropagation();
                        }
                    }, true);
                });
            });
        </script>
    @endpush

</div>
