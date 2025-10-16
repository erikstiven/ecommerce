<x-app-layout>
    <x-container class="px-4 my-8">

        @php
            /* ===== Estilos generales ===== */

            // Tarjeta base blanca con hover sutil
            $cardBase = '
                relative overflow-hidden bg-white shadow-lg ring-1 ring-black/5
                transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-xl
            ';
        @endphp

        {{-- ========================= HERO ========================= --}}
        <header class="text-center mb-8">
            <h2 class="flex items-center justify-center gap-2 text-4xl md:text-5xl font-extrabold text-purple-700">
                Sobre nosotros
            </h2>
            <p class="mt-2 text-gray-600">
                Somos un taller de costura y confección en Machala. Diseñamos y producimos uniformes escolares,
                deportivos y dotación corporativa con acabados de calidad.
            </p>
        </header>

        {{-- ========================= SECCIÓN 1 ========================= --}}
        <section class="mt-8 mx-auto w-full">
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-[2fr_1fr] items-stretch">

                {{-- CARD: QUIÉNES SOMOS --}}
                <div class="p-6 {{ $cardBase }}">
                    <h3 class="text-lg font-semibold text-gray-900">Quiénes somos</h3>
                    <p class="mt-2 text-gray-700 leading-relaxed">
                        Desde el año 2000 ayudamos a colegios, empresas y emprendedores a transformar sus ideas en
                        prendas funcionales y duraderas. Combinamos el trabajo artesanal con maquinaria industrial para
                        entregar a tiempo y con precisión.
                    </p>

                    <div class="mt-4 grid gap-3 sm:grid-cols-3">
                        <div class="rounded-xl border border-gray-200 bg-white/70 p-3 backdrop-blur">
                            <div class="text-2xl font-bold text-purple-700">+20 años</div>
                            <div class="text-sm text-gray-600">de experiencia</div>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-white/70 p-3 backdrop-blur">
                            <div class="text-2xl font-bold text-purple-700">4.000</div>
                            <div class="text-sm text-gray-600">prendas / mes</div>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-white/70 p-3 backdrop-blur">
                            <div class="text-2xl font-bold text-purple-700">24 h</div>
                            <div class="text-sm text-gray-600">muestras rápidas*</div>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-3" aria-label="Galería del taller">
                        @foreach (['bordado', 'serigrafia', 'doblado-prendas', 'local'] as $img)
                            <div class="relative w-full rounded-xl overflow-hidden border border-gray-200 bg-white">
                                <div class="w-full" style="padding-top:100%;"></div>
                                <img src="{{ asset('img/about/' . $img . '.svg') }}" alt="Imagen del taller"
                                    class="absolute inset-0 w-full h-full object-cover" loading="lazy"
                                    onerror="this.onerror=null;this.src='{{ asset('img/sin-imagen.jpg') }}';">
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- CARD: DIFERENCIALES --}}
                <div class="p-6 flex flex-col {{ $cardBase }}">
                    <h3 class="text-lg font-semibold text-gray-900">¿Qué nos hace diferentes?</h3>
                    <ul class="mt-2 space-y-2 text-gray-700 text-sm">
                        <li>✔ Control de calidad en corte, confección y terminaciones pieza por pieza.</li>
                        <li>✔ Producción flexible: desde 12 unidades en adelante</li>
                        <li>✔ Asesoría en telas, tallajes, etc.</li>
                    </ul>

                    <h4 class="mt-5 text-sm font-medium text-gray-900">Capacidades del taller</h4>
                    <ul class="mt-1 space-y-1 text-gray-700 text-sm">
                        <li><b>Confección:</b> polos, camisetas, joggers, buzos, uniformes y mas</li>
                        <li><b>Personalización:</b> serigrafía, bordado y sublimado.</li>
                        <li><b>Materiales:</b> algodón peinado, drifit, franela, interlock, microfibra.</li>
                        <li><b>Tallas:</b> infantil a adulto.</li>
                        <li><b>Plazos guía:</b> producción 7–15 días (según volumen).</li>
                    </ul>

                    <a href="/ubicacion"
                        class="mt-6 inline-flex items-center justify-center gap-2 rounded-xl bg-purple-600 px-4 py-3 text-sm font-medium text-white transition hover:bg-purple-700 focus-visible:ring-2 focus-visible:ring-purple-400 w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24"
                            fill="currentColor" aria-hidden="true">
                            <path
                                d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5Z" />
                        </svg>
                        Cómo llegar
                    </a>
                </div>

            </div>
        </section>

        {{-- ========================= SECCIÓN 2 ========================= --}}
        <section class="mt-8 grid gap-6 md:grid-cols-2">
            {{-- CARD: PROCESO --}}
            <div class="p-6 {{ $cardBase }}">
                <h3 class="text-lg font-semibold text-gray-900">Nuestro proceso</h3>
                <ol class="mt-3 space-y-3 text-sm text-gray-700">
                    <li><b>1) Cotización:</b> cuéntanos tipo de prenda, cantidades y diseño.</li>
                    <li><b>2) Muestra y ajustes:</b> validamos el diseño personalizado, tallas, tela y colores.</li>
                    <li><b>3) Producción:</b> corte, confección y terminaciones.</li>
                    <li><b>4) Control y entrega:</b> revisión final y empaque por tallas.</li>
                </ol>

                <h4 class="mt-5 text-sm font-medium text-gray-900">Clientes y sectores</h4>
                <ul class="mt-1 text-sm text-gray-700 space-y-1">
                    <li>• <b>Educación:</b> uniformes escolares y deportivos para colegios y academias.</li>
                    <li>• <b>Emprendedores:</b> producción de prendas personalizadas para marcas propias o negocios
                        locales.</li>
                    <li>• <b>Deportes:</b> uniformes para clubes, ligas y campeonatos interbarriales.</li>
                </ul>
            </div>

            {{-- CARD: CONTACTO (mantener igual) --}}
            <div
                class="relative overflow-hidden bg-white shadow-md transition-all duration-500 ease-out hover:-translate-y-1 hover:shadow-xl group cursor-pointer">

                {{-- Fondo verde visible solo en hover --}}
                <div
                    class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-emerald-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                </div>

                <div
                    class="relative flex flex-col items-center justify-center text-center p-10 transition-colors duration-500">

                    {{-- Título principal --}}
                    <h3
                        class="text-3xl md:text-4xl font-extrabold tracking-tight mb-6 text-gray-900 transition-colors duration-500 group-hover:text-white">
                        ¡Contáctanos!
                    </h3>

                    {{-- Ícono con mensaje prellenado --}}
                    <a href="https://wa.me/593989009428?text=Hola%2C%20me%20interesan%20los%20servicios%20y%20productos%20que%20muestran%20en%20su%20p%C3%A1gina%20web."
                        target="_blank"
                        class="flex flex-col items-center justify-center gap-3 transition-transform duration-300 hover:scale-105">
                        <img src="https://cdn2.iconfinder.com/data/icons/social-messaging-ui-color-shapes-2-free/128/social-whatsapp-circle-1024.png"
                            alt="WhatsApp" class="w-20 h-20 drop-shadow-lg select-none transition-all duration-500">
                        <span
                            class="text-base font-medium text-gray-700 transition-colors duration-500 group-hover:text-white">
                            Escríbenos por WhatsApp
                        </span>
                    </a>
                </div>
            </div>
        </section>

    </x-container>
</x-app-layout>
