<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @endpush

    <!-- Slider principal -->
    <div class="swiper mb-12">
        <div class="swiper-wrapper">
            @foreach ($covers as $cover)
                <div class="swiper-slide">
                    <img src="{{ $cover->image }}" class="w-full aspect-[3/1] object-cover object-center" alt="">
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        {{-- <div class="swiper-scrollbar"></div> --}}
    </div>

    {{-- Contenedor de productos agregados recientemente --}}
    <x-container class="px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-100 mb-4">
            Últimos productos
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($lastProducts as $product)
                <article
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 flex flex-col">
                    <!-- Imagen -->
                    <div class="bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" loading="lazy"
                            onerror="this.onerror=null; this.src='/img/Image_placeholder_4.jpg';"
                            class="object-contain h-48 w-full" />
                    </div>

                    <!-- Contenido -->
                    <div class="flex flex-col justify-between flex-grow p-5">
                        <div>
                            <h1 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-1 line-clamp-2">
                                {{ $product->name }}
                            </h1>
                            <p class="text-gray-500 dark:text-gray-300 mb-4">
                                $ {{ $product->price }}
                            </p>
                        </div>

                        <!-- Botón al fondo -->

                        <a href="{{ route('products.show', $product) }}"
                            class="relative inline-flex items-center justify-center px-5 py-2.5 overflow-hidden font-semibold text-white rounded-lg group bg-gradient-to-br from-violet-600 to-blue-400 hover:from-violet-700 hover:to-blue-500 shadow-md hover:shadow-lg transition-all duration-200">
                            <span
                                class="absolute w-0 h-0 transition-all duration-300 ease-out bg-white rounded-full group-hover:w-48 group-hover:h-48 opacity-10"></span>
                            <span class="relative">Ver detalles</span>
                        </a>


                    </div>
                </article>
            @endforeach
        </div>
    </x-container>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            const swiper = new Swiper('.swiper', {
                loop: true,
                autoplay: {
                    delay: 8000
                },
                pagination: {
                    el: '.swiper-pagination'
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                // scrollbar: { el: '.swiper-scrollbar' },
            });
        </script>
    @endpush
</x-app-layout>
