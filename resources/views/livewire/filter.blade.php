<div class="bg-white py-12">
    <x-container class="px-4 md:flex">
        @if (count($options))
            <aside class="md:w-52 md:flex-shrink-0 md:mr-8 mb-8 md:mb-0">
                <ul class="space-y-4">
                    @foreach ($options as $option)
                        <li x-data="{ open: true }">
                            <button
                                class="px-4 py-2 bg-gray-200 w-full text-left text-gray-700 flex justify-between items-center"
                                x-on:click="open = !open">
                                {{ $option['name'] }}
                                <i class="fa-solid fa-angle-down"
                                    x-bind:class="{ 'fa-angle-down': open, 'fa-angle-up': !open }"></i>
                            </button>
                            <ul class="mt-2 space-y-2" x-show="open">
                                @foreach ($option['features'] as $feature)
                                    <li>
                                        <label class="inline-flex items-center">
                                            <x-checkbox value="{{ $feature['id'] }}" wire:model.live="selected_features"
                                                class="mr-2" />
                                            {{ $feature['description'] }}
                                        </label>
                                    </li>
                                @endforeach

                            </ul>
                        </li>
                    @endforeach
                </ul>
            </aside>
        @endif
        <div class="md:flex-1">

            <div class="flex items-center">
                <span class="mr-2">
                    Ordenar por
                </span>
                <x-select wire:model.live="orderBy">
                    <option value="1">Relevancia</option>

                    <option value="2">Precio: Mayor a menor</option>

                    <option value="3">Precio: Menor a mayor</option>
                </x-select>
            </div>

            <hr class="my-4">

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <article
                        class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 flex flex-col">
                        <!-- Imagen -->
                        <div class="overflow-hidden">
                             <img src="{{ $product->image }}" {{-- Si tus imágenes están en storage; si no, usa $product->image --}}
                            alt="{{ $product->name }}" loading="lazy"
                            onerror="this.onerror=null; this.src='/img/Image_placeholder_4.jpg';"
                            class="block w-auto max-h-[420px] md:max-h-[520px] object-contain">
                        </div>

                        <!-- Contenido -->
                        <div class="flex flex-col justify-between flex-grow p-5">
                            <div>
                                <h1 class="text-lg font-bold text-gray-800 mb-1 line-clamp-2 min-h-[56px]">
                                    {{ $product->name }}
                                </h1>
                                <p class="text-gray-600 mb-4 font-medium">
                                    $ {{ number_format($product->price, 2) }}
                                </p>
                            </div>

                            <!-- Botón fijo al fondo -->
                            <a href="{{ route('products.show', $product) }}"
                                class="mt-auto block w-full text-center bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-2 rounded-lg font-semibold hover:from-purple-700 hover:to-indigo-700 transition-all duration-300">
                                Ver más
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- paginacion de productos --}}
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </x-container>
</div>
