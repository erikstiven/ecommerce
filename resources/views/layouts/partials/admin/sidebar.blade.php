@php
    $links = [
        [
            'icon' => 'home',
            'name' => __('Dashboard'),
            'route' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
        ],
        [
            'icon' => 'bar-chart-2',
            'name' => 'Estadísticas',
            'route' => route('admin.estadisticas'),
            'active' => request()->routeIs('admin.estadisticas'),
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
    class="relative h-screen bg-slate-950 border-r border-slate-800 transition-all duration-300 ease-in-out overflow-hidden flex flex-col"
    :class="sidebarCollapsed ? 'w-16' : 'w-64'"
    @mouseenter="sidebarCollapsed = false"
    @mouseleave="sidebarCollapsed = true"
    aria-label="Sidebar">

    {{-- Header --}}
    <div class="border-b border-slate-800/80 px-4 py-4">
        <div class="flex items-center justify-center gap-2">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-8 w-8 object-contain">
            <span class="text-white font-semibold text-base tracking-wide" x-show="!sidebarCollapsed" x-cloak>
                Codecima
            </span>
        </div>
    </div>

    {{-- Menú --}}
    <nav class="flex-1 px-2 py-4 overflow-y-auto [&::-webkit-scrollbar]:hidden"
        style="scrollbar-width: none; -ms-overflow-style: none;">
        <ul class="space-y-1">
            @foreach ($links as $link)
                <li>
                    @isset($link['header'])
                        <div class="px-3 py-2 text-[11px] font-semibold tracking-widest text-slate-400 uppercase"
                            x-show="!sidebarCollapsed" x-cloak>
                            {{ $link['header'] }}
                        </div>
                    @else
                        <a href="{{ $link['route'] }}"
                            class="group relative flex items-center rounded-lg px-3 py-2 text-slate-200 hover:bg-slate-800/80 transition-colors {{ $link['active'] ? 'bg-indigo-500/20 ring-1 ring-indigo-400/40 text-white' : '' }}"
                            :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                            title="{{ $link['name'] }}">
                            <span class="inline-flex w-6 h-6 justify-center items-center">
                                <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5"></i>
                            </span>
                            <span x-show="!sidebarCollapsed" x-cloak x-transition>
                                {{ $link['name'] }}
                            </span>
                            <span x-show="sidebarCollapsed" x-cloak
                                class="pointer-events-none absolute left-full ml-3 whitespace-nowrap rounded-md bg-slate-800 px-3 py-1 text-xs text-white shadow-lg">
                                {{ $link['name'] }}
                            </span>
                        </a>
                    @endisset
                </li>
            @endforeach
        </ul>
    </nav>

    {{-- Footer perfil --}}
    <div class="mt-auto border-t border-slate-800/80 px-3 py-4 bg-slate-900/60">
        <div class="flex flex-col items-center text-center"
            :class="sidebarCollapsed ? 'gap-0' : 'gap-2'">
            <img class="h-10 w-10 rounded-full object-cover ring-2 ring-slate-700"
                src="{{ Auth::user()->profile_photo_url }}"
                alt="{{ Auth::user()->name }}">
            <div x-show="!sidebarCollapsed" x-cloak>
                <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-400">Administrador</p>
            </div>
        </div>
        <div class="mt-4 space-y-1" :class="sidebarCollapsed ? 'pt-2' : ''">
            <a href="{{ route('profile.show') }}"
                class="group relative flex items-center rounded-lg px-3 py-2 text-slate-200 hover:bg-slate-800/80 transition-colors"
                :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                title="{{ __('navigation.profile') }}">
                <span class="inline-flex w-5 h-5 justify-center items-center">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </span>
                <span x-show="!sidebarCollapsed" x-cloak x-transition>
                    {{ __('navigation.profile') }}
                </span>
                {{-- <span x-show="sidebarCollapsed" x-cloak
                    class="pointer-events-none absolute left-full ml-3 whitespace-nowrap rounded-md bg-slate-800 px-3 py-1 text-xs text-white shadow-lg">
                    {{ __('navigation.profile') }}
                </span> --}}
            </a>
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <button type="submit"
                    class="group relative w-full flex items-center rounded-lg px-3 py-2 text-slate-200 hover:bg-slate-800/80 transition-colors"
                    :class="sidebarCollapsed ? 'justify-center' : 'gap-3'">
                    <span class="inline-flex w-5 h-5 justify-center items-center">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </span>
                    <span x-show="!sidebarCollapsed" x-cloak x-transition>
                        {{ __('navigation.log_out') }}
                    </span>
                    <span x-show="sidebarCollapsed" x-cloak
                        class="pointer-events-none absolute left-full ml-3 whitespace-nowrap rounded-md bg-slate-800 px-3 py-1 text-xs text-white shadow-lg">
                        {{ __('navigation.log_out') }}
                    </span>
                </button>
            </form>
        </div>
    </div>
</aside>
