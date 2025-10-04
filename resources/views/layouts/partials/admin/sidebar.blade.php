@php
    $links = [
        [
            'icon' => 'home',
            'name' => 'Dashboard',
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
    class="fixed top-0 left-0 z-40 w-64 h-[100dvh] pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    :class="{
    
        'translate-x-0 ease-out': sidebarOpen,
        '-translate-x-full ease-in': !sidebarOpen
    }"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach ($links as $link)
                <li>
                    @isset($link['header'])
                        <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">
                            {{ $link['header'] }}

                        </div>
                    @else
                        <a href="{{ $link['route'] }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ $link['active'] ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                            {{-- <span class="inline-flex w-6 h-6 justify-center items-center">
                            <i class="fa-solid {{ $link['icon'] }}"></i>
                        {{-- <span class="inline-flex w-6 h-6 justify-center items-center">
                            <i class="{{ $link['icon'] }}"></i>
                        </span> --}}
                            <span class="inline-flex w-6 h-6 justify-center items-center">
                                <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5"></i>
                            </span>
                            <span class="ms-2">
                                {{ $link['name'] }}
                            </span>
                        </a>
                    @endisset
                </li>
            @endforeach
        </ul>
    </div>
</aside>
