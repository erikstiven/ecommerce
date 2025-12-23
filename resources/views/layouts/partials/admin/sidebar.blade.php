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
    class="relative h-screen bg-slate-900 border-r border-slate-800 transition-all duration-300 overflow-x-hidden"
    :class="sidebarCollapsed ? 'w-16' : 'w-64'"
    aria-label="Sidebar">
    <div class="h-full pb-4 pt-6 overflow-y-auto bg-slate-900"
        :class="sidebarCollapsed ? 'px-2' : 'px-3'">
        {{-- Navegación principal --}}
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
                            <span x-show="!sidebarCollapsed" x-cloak>
                                {{ $link['name'] }}
                            </span>
                        </a>
                    @endisset
                </li>
            @endforeach
        </ul>
    </div>
</aside>
