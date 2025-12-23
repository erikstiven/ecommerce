@php
    $links = [
        [
            'icon' => 'home',
            'name' => __('Dashboard'),
            'route' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
        ],
        [
            'header' => 'Administrar Pagina',
        ],
        [
            'name' => 'Opciones',
            'icon' => 'bolt',
            'route' => route('admin.options.index'),
            'active' => request()->routeIs('admin.options.*'),
        ],
        [
            // Familias de productos
            'icon' => 'layers',
            'name' => 'Familias',
            'route' => route('admin.families.index'),
            'active' => request()->routeIs('admin.families.*'),
        ],
        [
            // Categorías de productos
            'icon' => 'grid',
            'name' => 'Categorias',
            'route' => route('admin.categories.index'),
            'active' => request()->routeIs('admin.categories.*'),
        ],
        [
            // Subcategorías de productos
            'icon' => 'list',
            'name' => 'Subcategorias',
            'route' => route('admin.subcategories.index'),
            'active' => request()->routeIs('admin.subcategories.*'),
        ],
        [
            // Productos
            'icon' => 'package',
            'name' => 'Productos',
            'route' => route('admin.products.index'),
            'active' => request()->routeIs('admin.products.*'),
        ],
        [
            // Portadas
            'icon' => 'image',
            'name' => 'Portadas',
            'route' => route('admin.covers.index'),
            'active' => request()->routeIs('admin.covers.*'),
        ],
        [
            'header' => 'Ordenes y envíos',
        ],
        [
            // Órdenes
            'icon' => 'shopping-cart',
            'name' => 'Ordenes',
            'route' => route('admin.orders.index'),
            'active' => request()->routeIs('admin.orders.*'),
        ],
        [
            // Conductores
            'icon' => 'truck',
            'name' => 'Conductores',
            'route' => route('admin.drivers.index'),
            'active' => request()->routeIs('admin.drivers.*'),
        ],
        [
            // Envíos
            'icon' => 'map-pin',
            'name' => 'Envios',
            'route' => route('admin.shipments.index'),
            'active' => request()->routeIs('admin.shipments.*'),
        ],
    ];

@endphp
<aside id="logo-sidebar"
    class="relative h-screen bg-slate-900 border-r border-slate-800 transition-all duration-300 ease-in-out overflow-x-hidden flex flex-col"
    :class="sidebarCollapsed ? 'w-16' : 'w-64'"
    aria-label="Sidebar">
    {{-- Zona superior: logo + toggle --}}
    <div class="relative flex items-center justify-center px-3 py-4">
        <button type="button"
            class="absolute top-1/2 -right-3 z-10 inline-flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-full bg-white text-slate-600 shadow-md ring-1 ring-slate-200 hover:text-slate-800"
            @click="sidebarCollapsed = !sidebarCollapsed">
            <span class="sr-only">Toggle sidebar</span>
            <svg class="h-4 w-4 transition-transform duration-300"
                :class="sidebarCollapsed ? 'rotate-180' : ''"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </button>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center gap-2">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-8 w-8 object-contain">
            <span class="text-white font-semibold text-base" x-show="!sidebarCollapsed" x-cloak>
                Codecima
            </span>
        </a>
    </div>

    {{-- Zona central: menú --}}
    <div class="flex-1 overflow-y-auto pb-4"
        :class="sidebarCollapsed ? 'px-2' : 'px-3'">
        <ul class="space-y-2 font-medium">
            @foreach ($links as $link)
                <li>
                    @isset($link['header'])
                        <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase"
                            x-show="!sidebarCollapsed" x-cloak>
                            {{ $link['header'] }}
                        </div>
                    @else
                        <a href="{{ $link['route'] }}"
                            class="flex items-center rounded-lg px-3 py-2 text-slate-200 hover:bg-slate-800 transition-colors {{ $link['active'] ? 'bg-slate-800' : '' }}"
                            :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                            title="{{ $link['name'] }}">
                            {{-- Icono siempre visible --}}
                            <span class="inline-flex w-6 h-6 justify-center items-center">
                                <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5"></i>
                            </span>
                            <span x-show="!sidebarCollapsed" x-cloak x-transition>
                                {{ $link['name'] }}
                            </span>
                        </a>
                    @endisset
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Zona inferior: perfil --}}
    <div class="border-t border-slate-800 px-3 py-4"
        :class="sidebarCollapsed ? 'px-2' : 'px-3'">
        <div class="flex items-center"
            :class="sidebarCollapsed ? 'justify-center' : 'gap-3'">
            <img class="h-8 w-8 rounded-full object-cover"
                src="{{ Auth::user()->profile_photo_url }}"
                alt="{{ Auth::user()->name }}">
            <div x-show="!sidebarCollapsed" x-cloak>
                <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-400">Administrador</p>
            </div>
        </div>
        <div class="mt-4 space-y-1">
            <a href="{{ route('profile.show') }}"
                class="flex items-center rounded-lg px-3 py-2 text-slate-200 hover:bg-slate-800 transition-colors"
                :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                title="{{ __('navigation.profile') }}">
                <span class="inline-flex w-5 h-5 justify-center items-center">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </span>
                <span x-show="!sidebarCollapsed" x-cloak x-transition>
                    {{ __('navigation.profile') }}
                </span>
            </a>
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <button type="submit"
                    class="w-full flex items-center rounded-lg px-3 py-2 text-slate-200 hover:bg-slate-800 transition-colors"
                    :class="sidebarCollapsed ? 'justify-center' : 'gap-3'">
                    <span class="inline-flex w-5 h-5 justify-center items-center">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </span>
                    <span x-show="!sidebarCollapsed" x-cloak x-transition>
                        {{ __('navigation.log_out') }}
                    </span>
                </button>
            </form>
        </div>
    </div>
</aside>
