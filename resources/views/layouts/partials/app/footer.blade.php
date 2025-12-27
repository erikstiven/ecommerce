<footer class="bg-gradient-to-r from-[#3b0764] via-[#1e3a8a] to-[#7e22ce] text-white">
    <div class="max-w-screen-xl mx-auto px-6 md:px-8 py-10 lg:py-12">

        <!-- ============== TOP ============== -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-y-10 gap-x-8 md:items-center">

            <!-- IDENTIDAD -->
            <div class="md:col-span-3 flex flex-col items-center md:items-start text-center md:text-left space-y-4">
                <a href="/" class="inline-flex" aria-label="Ir al inicio">
                    <img src="/img/logohmbsport.svg" alt="HMB Sport" class="h-16 md:h-20 object-contain mx-auto" />
                </a>
                <div class="space-y-1">
                    <p class="text-base font-semibold text-white">HMB Sport</p>
                    <p class="text-sm text-white/80">Taller de costura y confección en Machala.</p>
                </div>
            </div>

            <!-- CONTACTO ESENCIAL -->
            <div class="md:col-span-3">
                <h2 class="mb-3 font-semibold uppercase tracking-wide text-white/90">Contacto</h2>
                <ul class="space-y-2 text-white/90">
                    <li>
                        <a href="mailto:quisniahugo@hotmail.com"
                            class="hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60 rounded">
                            quisniahugo@hotmail.com
                        </a>
                    </li>
                </ul>
            </div>

            <!-- REDES SOCIALES -->
            <div class="md:col-span-3">
                <h2 class="mb-3 font-semibold uppercase tracking-wide text-white/90">Redes sociales</h2>
                <div class="flex justify-center md:justify-start gap-4">
                    <a href="https://www.facebook.com/hmbsportt" target="_blank" rel="noopener noreferrer"
                        aria-label="Facebook"
                        class="w-11 h-11 flex items-center justify-center rounded-full border border-white/20 bg-white/5
                        hover:bg-[#1877F2]/80 hover:scale-110 hover:shadow-lg transition
                        focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60">
                        <i class="fab fa-facebook-f text-white"></i>
                    </a>

                    <a href="https://www.instagram.com/hmb_sport/" target="_blank" rel="noopener noreferrer"
                        aria-label="Instagram"
                        class="w-11 h-11 flex items-center justify-center rounded-full border border-white/20 bg-white/5
                        hover:bg-gradient-to-tr from-pink-500 via-red-500 to-yellow-400 hover:scale-110 hover:shadow-lg transition
                        focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60">
                        <i class="fab fa-instagram text-white"></i>
                    </a>

                    <a href="https://www.tiktok.com/@hmbsport_ec?lang=es" target="_blank" rel="noopener noreferrer"
                        aria-label="TikTok"
                        class="w-11 h-11 flex items-center justify-center rounded-full border border-white/20 bg-white/5
                        hover:bg-black/80 hover:scale-110 hover:shadow-lg transition
                        focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60">
                        <i class="fab fa-tiktok text-white"></i>
                    </a>
                </div>
            </div>

            <!-- ENLACES INFORMATIVOS / LEGALES -->
            <div class="md:col-span-3">
                <h2 class="mb-3 font-semibold uppercase tracking-wide text-white/90">Información</h2>
                <ul class="space-y-2 text-white/90">
                    <li>
                        <a href="{{ route('legal.terms') }}"
                            class="hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60 rounded">
                            Términos y condiciones
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('legal.privacy') }}"
                            class="hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60 rounded">
                            Política de privacidad
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('legal.returns') }}"
                            class="hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60 rounded">
                            Política de devoluciones
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('faq.index') }}"
                            class="hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60 rounded">
                            Preguntas frecuentes
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- ============== DIVISOR ============== -->
        <hr class="my-8 border-white/20" />

        <!-- ============== BOTTOM ============== -->
        <div class="flex flex-col items-center gap-2 text-center">
            <p class="text-sm text-white/70">
                © 2025 HMB Sport. Todos los derechos reservados.
            </p>
        </div>
    </div>
</footer>
