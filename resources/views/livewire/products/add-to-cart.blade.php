<div>
    <h1 class="text-2xl text-black mb-2 font-bold dark:text-white">
        {{ $product->name }}
    </h1>

    <div class="flex items-center space-x-2 mb-4">
        <ul class="flex space-x-1 text-sm">
            <!-- Estrellas permanecen iguales -->
            <li><i class="fa-solid fa-star text-yellow-400"></i></li>
            <li><i class="fa-solid fa-star text-yellow-400"></i></li>
            <li><i class="fa-solid fa-star text-yellow-400"></i></li>
            <li><i class="fa-solid fa-star text-yellow-400"></i></li>
            <li><i class="fa-solid fa-star text-yellow-400"></i></li>
        </ul>
        <p class="text-sm text-gray-700 dark:text-white">4,1 (55)</p>
    </div>

    <!-- Descripción del producto -->
    <div class="text-sm mb-4 dark:text-white">
        {{ $product->description }}
    </div>

    <div class="flex items-center justify-between">
        <p class="font-semibold text-2xl text-gray-600 mb-4 dark:text-white">
            $/ {{ $product->price }}
        </p>
        <p class="text-sm text-gray-700 dark:text-white">
            Stock: {{ $stock ?? 0 }}
        </p>
    </div>

    <!-- Control de cantidad -->
    <div class="flex items-center space-x-6 mb-6" x-data="{
        qty: @entangle('qty'),
        stock: @entangle('stock')
    }">
        <button class="btn btn-gradient-gray dark:text-white" x-on:click="qty = qty - 1" x-bind:disabled="qty == 1">
            -
        </button>
        <span x-text="qty" class="inline-block w-2 text-center dark:text-white"></span>
        <button class="btn btn-gradient-gray dark:text-white" x-on:click="qty = qty + 1" :disabled="qty == stock">
            +
        </button>
    </div>

    <!-- Opciones y características -->
    <div class="flex flex-wrap">
        @foreach ($product->options as $option)
            <div class="mr-4 mb-4">
                <p class="font-semibold text-lg mb-2 dark:text-white">
                    {{ $option->name }}
                </p>
                <ul class="flex items-center space-x-4">
                    @foreach ($option->pivot->features as $feature)
                        <li>
                            @switch($option->type)
                                @case(1)
                                    <button
                                        class="w-20 h-8 font-semibold uppercase text-sm rounded-lg {{ $selectedFeatures[$option->id] == $feature['id'] ? 'bg-purple-500 text-white' : 'border border-gray-300 text-gray-700 dark:text-white' }}"
                                        wire:click="set('selectedFeatures.{{ $option->id }}', '{{ $feature['id'] }}')">
                                        {{ $feature['value'] }}
                                    </button>
                                    @break

                                @case(2)
                                    <div
                                        class="p-0.5 border-2 rounded-lg flex items-center -mt-1.5 space-x-2 {{ $selectedFeatures[$option->id] == $feature['id'] ? 'border-purple-600' : 'border-transparent' }}">
                                        <button class="w-20 h-8 rounded-lg border border-gray-200 dark:text-white"
                                            wire:click="set('selectedFeatures.{{ $option->id }}', '{{ $feature['id'] }}')"
                                            style="background-color: {{ $feature['value'] }}">
                                        </button>
                                    </div>
                                    @break
                            @endswitch
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <!-- Botón agregar al carrito -->
    <button class="btn btn-gradient-purple w-full mb-6 dark:text-white"
            wire:click="add_to_cart" wire:loading.attr="disabled">
        Agregar al carrito
    </button>

    <!-- Información de despacho -->
    <div class="text-gray-700 flex items-center space-x-4 dark:text-white">
        <i class="fa-solid fa-truck-fast text-2xl"></i>
        <p>Despacho a domicilio</p>
    </div>
</div>
