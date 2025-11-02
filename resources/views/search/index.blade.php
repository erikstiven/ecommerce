<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">
            Resultados para: "{{ $query }}"
        </h1>

        @if ($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <article
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 flex flex-col">
                        <!-- Imagen -->
                        <div class="overflow-hidden bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" loading="lazy"
                                onerror="this.onerror=null; this.src='/img/Image_placeholder_4.jpg';"
                                class="w-full aspect-[4/3] object-cover object-center transition-transform duration-300 hover:scale-110">
                        </div>

                        <!-- Contenido -->
                        <div class="flex flex-col justify-between flex-grow p-5">
                            <div>
                                <h1 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-1 line-clamp-2">
                                    {{ $product->name }}
                                </h1>
                                <p class="text-gray-500 dark:text-gray-300 mb-4">
                                    $ {{ number_format($product->price, 2) }}
                                </p>
                            </div>

                            <a href="{{ route('products.show', $product) }}"
                                class="mt-auto block text-center bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg font-semibold transition">
                                Ver más
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $products->appends(['search' => $query])->links() }}
            </div>
        @else
            <p class="text-gray-600 dark:text-gray-300 text-center text-lg mt-8">
                No se encontraron productos que coincidan con tu búsqueda.
            </p>
        @endif
    </div>
</x-app-layout>
