<x-app-layout>

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @endpush


    <!-- Slider main container -->
    <div class="swiper mb-12">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            @foreach ($covers as $cover)
                <div class="swiper-slide">
                    <img src="{{ $cover->image }}" class="w-full aspect-[3/1] object-cover object-center" alt="">
                </div>
            @endforeach
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <!-- If we need scrollbar -->
        {{-- <div class="swiper-scrollbar"></div> --}}
    </div>

    {{-- contenedor de productos agregados resientemenre --}}

    <x-container>
        <h1 class="text-2xl font-bold text-gray-700 mb-4">
            Ultimos productos
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($lastProducts as $product)
                <article
                    class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 flex flex-col">
                    <!-- Imagen -->
                    <div class="overflow-hidden">
                        <img src="{{ $product->image }}"
                            class="w-full h-48 object-cover transition-transform duration-300 hover:scale-110">
                    </div>

                    <!-- Contenido -->
                    <div class="flex flex-col justify-between flex-grow p-5">
                        <div>
                            <h1 class="text-lg font-bold text-gray-800 mb-1 line-clamp-2">
                                {{ $product->name }}
                            </h1>
                            <p class="text-gray-500 mb-4">$ {{ $product->price }}</p>
                        </div>

                        <!-- Botón al fondo -->
                        <a href="{{ route('products.show', $product) }}"
                            class="mt-auto block text-center bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg font-semibold transition">
                            Ver más
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
                // Optional parameters
                loop: true,

                //Tiempo de cada portada
                autoplay: {
                    delay: 8000,
                },

                // If we need pagination
                pagination: {
                    el: '.swiper-pagination',
                },

                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },

                // // And if we need scrollbar
                // scrollbar: {
                //     el: '.swiper-scrollbar',
                // },
            });
        </script>
    @endpush

</x-app-layout>
