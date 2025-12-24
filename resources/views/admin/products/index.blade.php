{{-- <x-admin-layout :breadcrumbs="[
    [
        'name' => __('Dashboard'),
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Productos',
        'route' => route('admin.products.index'),
    ],
]">

    <x-slot name="action">
        <a href="{{ route('admin.products.create') }}" class="btn-gradient-blue">
            Nuevo
        </a>
    </x-slot>


    @if ($products->count())

        <div class="overflow-x-auto rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                    <tr>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 tracking-widest uppercase">
                            ID
                        </th>
                         <th
                            class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 tracking-widest uppercase">
                            SKU
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 tracking-widest uppercase">
                            Nombre
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 tracking-widest uppercase">
                            Precio
                        </th>
                       
                        <th
                            class="px-6 py-4 text-right text-xs font-bold text-gray-600 dark:text-gray-300 tracking-widest uppercase">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($products as $product)
                        <tr class="group hover:bg-blue-50 dark:hover:bg-gray-800 transition duration-200">
                            <td
                                class="px-6 py-4 text-sm font-semibold text-gray-700 dark:text-gray-200 group-hover:text-blue-600">
                                {{ $product->id }}
                            </td>
                            <td
                                class="px-6 py-4 text-sm font-semibold text-gray-700 dark:text-gray-200 group-hover:text-blue-600">
                                {{ $product->sku }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 group-hover:text-blue-600">
                                {{ $product->name }}
                            </td>
                             <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 group-hover:text-blue-600">
                                {{ $product->price }}
                            </td>
                           
                            <td class="px-6 py-4 text-sm text-right">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-md bg-blue-500 text-white text-xs font-medium shadow hover:bg-blue-600 hover:scale-105 transition-all duration-200">
                                    <i data-lucide="pencil" class="w-4 h-4"></i> Editar
                                </a>  
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @else
        <div class="p-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 flex items-center gap-2"
            role="alert">
            <!-- Icono de información -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M12 20.5a8.5 8.5 0 100-17 8.5 8.5 0 000 17z" />
            </svg>

            <span>
                <span class="font-medium">Info alert!</span> Todavía no hay productos registrados
            </span>
        </div>
    @endif


</x-admin-layout> --}}


<x-admin-layout 
    :breadcrumbs="[
        ['name' => __('Dashboard'), 'route' => route('admin.dashboard')],
        ['name' => 'Productos', 'route' => route('admin.products.index')],
    ]"
>


    <x-slot name="action">
        <a href="{{ route('admin.products.create') }}" class="btn-gradient-blue">
            Nuevo
        </a>
    </x-slot>


    {{-- Renderiza la tabla dinámica de productos --}}
    @livewire('admin.products.product-table')
</x-admin-layout>
