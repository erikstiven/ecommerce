<x-app-layout>
    <x-container class="px-4 my-8">
        <header class="text-center mb-8">
            <h2 class="flex items-center justify-center gap-2 text-4xl md:text-5xl font-extrabold text-purple-700">
                Política de devoluciones
            </h2>
            <p class="mt-1 text-xs text-gray-500">Última actualización: {{ now()->format('d/m/Y') }}</p>
        </header>

        <section class="space-y-6">
            <article class="p-6 bg-white rounded-2xl shadow-lg ring-1 ring-black/5">
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
    </x-container>
</x-app-layout>
