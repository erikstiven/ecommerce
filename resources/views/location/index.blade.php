<x-app-layout>
    <x-container class="px-4 my-8">

        {{-- ========================= HERO ========================= --}}
        <header class="text-center mb-8">
            <h2 class="flex items-center justify-center gap-2 text-4xl md:text-5xl font-extrabold text-purple-700">

                Ubicación
            </h2>
            <p class="mt-2 text-gray-600 max-w-2xl mx-auto">
                Estamos en la ciudad de <b>Machala, Ecuador</b>. Puedes visitarnos o contactarnos para pedidos
                personalizados. ¡Hacemos envíos a todo el país!
            </p>
        </header>

        {{-- ========================= MAPA (FULL WIDTH Y ALTURA REAL) ========================= --}}
        <section class="w-full">
            <div class="relative overflow-hidden rounded-2xl shadow-lg ring-1 ring-black/5">
                {{-- Wrapper con altura forzada y responsive --}}
                <div class="w-full" style="height:clamp(420px, 60vh, 720px);">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3981.028587707602!2d-79.95392!3d-3.2636928!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x90330fbbf896c7d7%3A0xeb99f3085f5faf72!2sHMB-SPORT!5e0!3m2!1ses!2sec!4v1696532538685!5m2!1ses!2sec"
                        class="block w-full h-full border-0"
                        style="filter:grayscale(0.05) contrast(1.05) brightness(1.05);" allowfullscreen loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" title="Ubicación HMB-SPORT en Google Maps">
                    </iframe>
                </div>
            </div>
        </section>


        {{-- ========================= INFO + CONTACTO (DOS TARJETAS) ========================= --}}
        <section class="mt-8 grid gap-6 md:grid-cols-2">
            {{-- CARD: INFORMACIÓN --}}
            <div class="p-6 bg-white rounded-2xl shadow-lg ring-1 ring-black/5 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-700" viewBox="0 0 24 24"
                            fill="currentColor" aria-hidden="true">
                            <path
                                d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5Z" />
                        </svg>
                        Dirección
                    </h3>
                    <p class="mt-2 text-gray-700 leading-relaxed">
                        <b>Tarqui y 11ª Norte</b> <br>
                        Frente al Colegio Henríquez Coello — Machala
                    </p>

                    <h4 class="mt-4 text-sm font-medium text-gray-900">Horario de atención</h4>
                    <p class="text-sm text-gray-700">
                        Lunes a Sábado — 09:00 a 18:00 <br>
                        Domingo — Cerrado
                    </p>
                </div>
            </div>

            {{-- CARD: CONTACTO --}}
            <div class="p-6 bg-white rounded-2xl shadow-lg ring-1 ring-black/5">
                <h3 class="text-lg font-semibold text-gray-900">Contáctanos</h3>
                <p class="mt-1 text-sm text-gray-600">Te atenderemos con gusto.</p>

                <div class="mt-4 space-y-4 text-sm">
                    <div>
                        <h4 class="font-medium text-gray-700">Correo</h4>
                        <a href="mailto:quisniahugo@hotmail.com"
                            class="text-purple-600 hover:text-purple-700">quisniahugo@hotmail.com</a>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-700">WhatsApp / Teléfonos</h4>
                        <ul class="mt-2 space-y-1 text-gray-700">
                            <li>📞 Cotizaciones: <a href="https://wa.me/593989009428"
                                    class="text-emerald-600 hover:underline">0989009428</a></li>
                            <li>📞 Cotizaciones: <a href="https://wa.me/593983284300"
                                    class="text-emerald-600 hover:underline">0983284300</a></li>
                            <li>📞 Ventas: <a href="https://wa.me/593979018689"
                                    class="text-emerald-600 hover:underline">0979018689</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

    </x-container>
</x-app-layout>
