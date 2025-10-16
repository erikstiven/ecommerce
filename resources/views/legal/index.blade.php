<x-app-layout>
    <x-container class="px-4 my-8">

        {{-- ========================= HERO ========================= --}}
        <header class="text-center mb-8">
            <h2 class="flex items-center justify-center gap-2 text-4xl md:text-5xl font-extrabold text-purple-700">
                Políticas y Condiciones
            </h2>
            <p class="mt-2 text-gray-600 max-w-2xl mx-auto">
                Conoce nuestros términos de uso, cómo protegemos tus datos y nuestra política de devoluciones por
                defectos de fábrica.
            </p>
            <p class="mt-1 text-xs text-gray-500">Última actualización: {{ now()->format('d/m/Y') }}</p>
        </header>

        {{-- ========================= ÍNDICE ========================= --}}
        <nav class="mb-8 grid gap-3 md:grid-cols-3">
            <a href="#terminos"
                class="group p-4 bg-white rounded-2xl shadow-lg ring-1 ring-black/5 hover:shadow-xl transition">
                <div class="flex items-center gap-2">
                    <span
                        class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-purple-50 text-purple-700">1</span>
                    <span class="font-semibold text-gray-900 group-hover:text-purple-700">Términos y condiciones</span>
                </div>
                <p class="mt-1 text-sm text-gray-600">Uso del sitio y responsabilidades.</p>
            </a>
            <a href="#privacidad"
                class="group p-4 bg-white rounded-2xl shadow-lg ring-1 ring-black/5 hover:shadow-xl transition">
                <div class="flex items-center gap-2">
                    <span
                        class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-purple-50 text-purple-700">2</span>
                    <span class="font-semibold text-gray-900 group-hover:text-purple-700">Política de privacidad</span>
                </div>
                <p class="mt-1 text-sm text-gray-600">Cómo protegemos tu información.</p>
            </a>
            <a href="#devoluciones"
                class="group p-4 bg-white rounded-2xl shadow-lg ring-1 ring-black/5 hover:shadow-xl transition">
                <div class="flex items-center gap-2">
                    <span
                        class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-purple-50 text-purple-700">3</span>
                    <span class="font-semibold text-gray-900 group-hover:text-purple-700">Devoluciones por
                        defectos</span>
                </div>
                <p class="mt-1 text-sm text-gray-600">Solo aplica por defectos de fábrica.</p>
            </a>
        </nav>

        {{-- ========================= CONTENIDO ========================= --}}
        <section class="space-y-10">

            {{-- ========= TÉRMINOS Y CONDICIONES ========= --}}
            <article id="terminos" class="p-6 bg-white rounded-2xl shadow-lg ring-1 ring-black/5">
                <h3 class="text-3xl font-bold text-gray-900 mb-2">Términos y condiciones</h3>
                <p class="text-gray-700">
                    Al utilizar este sitio web o realizar una compra con <b>HMB-SPORT</b>, aceptas los siguientes
                    términos y condiciones.
                    Si no estás de acuerdo, por favor, no utilices el sitio.
                </p>

                <ul class="mt-4 space-y-2 text-gray-700 list-disc list-inside">
                    <li>Los precios están expresados en dólares estadounidenses (USD) e incluyen impuestos aplicables.
                    </li>
                    <li>Los pedidos se procesan una vez confirmado el pago o comprobante.</li>
                    <li>Las imágenes son referenciales y pueden variar ligeramente según el lote o pantalla del
                        dispositivo.</li>
                    <li>Los envíos se realizan a todo Ecuador mediante Servientrega.</li>
                    <li>Las devoluciones solo aplican por <b>defectos de fábrica</b> conforme a nuestra política de
                        devoluciones.</li>
                    <li>Todo el contenido del sitio (textos, marcas, imágenes) es propiedad de HMB-SPORT y no puede
                        reproducirse sin autorización.</li>
                </ul>
            </article>

            {{-- ========= POLÍTICA DE PRIVACIDAD ========= --}}
            <article id="privacidad" class="p-6 bg-white rounded-2xl shadow-lg ring-1 ring-black/5">
                <h3 class="text-3xl font-bold text-gray-900 mb-2">Política de privacidad</h3>
                <p class="text-gray-700">
                    En <b>HMB-SPORT</b> valoramos tu privacidad. La información que recopilamos se utiliza únicamente
                    para procesar tus pedidos y mejorar tu experiencia de compra.
                </p>

                <div class="mt-4 space-y-2 text-gray-700">
                    <p><b>Datos que recopilamos:</b> nombre, correo, teléfono, dirección y datos de pago. También
                        utilizamos cookies necesarias para el funcionamiento del sitio.</p>
                    <p><b>Uso de la información:</b> procesar pedidos, coordinar envíos y enviarte información sobre tu
                        compra.</p>
                    <p><b>Protección:</b> tus datos son tratados de forma confidencial y no se comparten con terceros
                        salvo para fines logísticos o de pago.</p>
                    <p><b>Derechos:</b> puedes solicitar acceso, rectificación o eliminación de tus datos escribiendo a
                        <a href="mailto:quisniahugo@hotmail.com"
                            class="text-purple-700 hover:underline">quisniahugo@hotmail.com</a>.
                    </p>
                </div>
            </article>

            {{-- ========= POLÍTICA DE DEVOLUCIONES ========= --}}
            <article id="devoluciones" class="p-6 bg-white rounded-2xl shadow-lg ring-1 ring-black/5">
                <h3 class="text-3xl font-bold text-gray-900 mb-2">Política de devoluciones por defectos de fábrica</h3>
                <p class="text-gray-700">
                    En <b>HMB-SPORT</b> garantizamos la calidad de nuestros productos. Solo aceptamos devoluciones o
                    cambios si el producto presenta <b>defectos de fábrica</b>.
                </p>

                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div class="space-y-3">
                        <details open class="group p-4 rounded-xl ring-1 ring-black/5 hover:ring-purple-200 transition">
                            <summary class="font-semibold text-gray-900 cursor-pointer">1. Plazo para reportar</summary>
                            <p class="mt-2 text-gray-700">
                                Tienes hasta <b>7 días calendario</b> desde la recepción del pedido para reportar el
                                defecto.
                                Fuera de ese plazo no se podrán procesar solicitudes.
                            </p>
                        </details>

                        <details class="group p-4 rounded-xl ring-1 ring-black/5 hover:ring-purple-200 transition">
                            <summary class="font-semibold text-gray-900 cursor-pointer">2. Condiciones del producto
                            </summary>
                            <ul class="mt-2 text-gray-700 list-disc list-inside space-y-1">
                                <li>El producto debe estar sin uso, con etiquetas y empaque original.</li>
                                <li>Se debe enviar evidencia fotográfica o en video del defecto.</li>
                                <li>No se consideran defectos los daños por uso, manipulación o desgaste normal.</li>
                            </ul>
                        </details>

                        <details class="group p-4 rounded-xl ring-1 ring-black/5 hover:ring-purple-200 transition">
                            <summary class="font-semibold text-gray-900 cursor-pointer">3. Exclusiones</summary>
                            <ul class="mt-2 text-gray-700 list-disc list-inside space-y-1">
                                <li>Productos personalizados o hechos a pedido (salvo defecto de fábrica).</li>
                                <li>Artículos en liquidación (“final sale”).</li>

                            </ul>
                        </details>
                    </div>

                    <div class="space-y-3">
                        <details class="group p-4 rounded-xl ring-1 ring-black/5 hover:ring-purple-200 transition">
                            <summary class="font-semibold text-gray-900 cursor-pointer">4. Proceso de evaluación
                            </summary>
                            <ol class="mt-2 text-gray-700 list-decimal list-inside space-y-1">
                                <li>Contacta a nuestro equipo vía WhatsApp o correo con tu número de pedido y evidencia
                                    del defecto.</li>
                                <li>Evaluamos el caso en un plazo de <b>1–2 días hábiles</b>.</li>
                                <li>Si es necesario, solicitaremos el envío del producto para revisión.</li>
                            </ol>
                        </details>

                        <details class="group p-4 rounded-xl ring-1 ring-black/5 hover:ring-purple-200 transition">
                            <summary class="font-semibold text-gray-900 cursor-pointer">5. Soluciones</summary>
                            <p class="mt-2 text-gray-700">
                                Una vez confirmado el defecto, se aplicará una de las siguientes medidas:
                            </p>
                            <ul class="mt-2 text-gray-700 list-disc list-inside space-y-1">
                                <li><b>Reparación</b> sin costo, si es posible.</li>
                                <li><b>Reemplazo</b> por el mismo modelo o uno equivalente.</li>
                                <li><b>Reembolso</b> o nota de crédito si no es posible reparar o reemplazar.</li>
                            </ul>
                        </details>

                        <details class="group p-4 rounded-xl ring-1 ring-black/5 hover:ring-purple-200 transition">
                            <summary class="font-semibold text-gray-900 cursor-pointer">6. Costos de envío</summary>
                            <p class="mt-2 text-gray-700">
                                Si el defecto es confirmado, <b>HMB-SPORT</b> cubrirá los costos de transporte.

                            </p>
                        </details>
                    </div>
                </div>

                {{-- Contacto --}}
                <div class="mt-6 p-4 bg-gray-50 rounded-xl ring-1 ring-black/5">
                    <h4 class="font-semibold text-gray-900">¿Necesitas reportar un defecto?</h4>
                    <ul class="mt-2 text-sm text-gray-700 space-y-1">
                        <li>📧 Correo: <a href="mailto:quisniahugo@hotmail.com"
                                class="text-purple-700 hover:underline">quisniahugo@hotmail.com</a></li>
                        <li>📱 WhatsApp Cotizaciones:
                            <a href="https://wa.me/593989009428" class="text-emerald-600 hover:underline">0989009428</a>
                            /
                            <a href="https://wa.me/593983284300" class="text-emerald-600 hover:underline">0983284300</a>
                        </li>
                        <li>📱 WhatsApp Ventas: <a href="https://wa.me/593979018689"
                                class="text-emerald-600 hover:underline">0979018689</a></li>
                    </ul>
                </div>
            </article>
        </section>

        {{-- ========================= NOTA LEGAL ========================= --}}
        <section class="mt-10">
            <div class="p-5 bg-white rounded-2xl shadow-lg ring-1 ring-black/5">
                <p class="text-xs text-gray-500 leading-relaxed">
                    Nota: Este contenido es de carácter informativo. En caso de requerir adecuación legal conforme a la
                    Ley Orgánica de Protección de Datos Personales del Ecuador u otras normas comerciales, se recomienda
                    revisión por un profesional especializado.
                </p>
            </div>
        </section>

        {{-- ========================= FOOTER ========================= --}}
        <footer class="mt-8 text-center text-sm text-gray-500 flex flex-col items-center justify-center gap-5 pb-10">


            <!-- Botón circular mejorado -->
            <a href="#top"
                class="group relative flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden cursor-pointer">

                <!-- Ícono -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                    class="w-6 h-6 z-10 transition-transform duration-300 group-hover:-translate-y-1">
                    <path fill="currentColor" d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3
                0l-160 160c-12.5 12.5-12.5 32.8
                0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7
                14.3 32 32 32s32-14.3 32-32V141.2L329.4
                246.6c12.5 12.5 32.8 12.5 45.3
                0s12.5-32.8 0-45.3l-160-160z" />
                </svg>

                <!-- Fondo animado -->
                <span
                    class="absolute inset-0 rounded-full bg-purple-700/0 group-hover:bg-purple-700/90 transition-all duration-300"></span>
            </a>

        </footer>

        <!-- Desplazamiento suave -->
        <style>
            html {
                scroll-behavior: smooth;
            }
        </style>


    </x-container>
</x-app-layout>
