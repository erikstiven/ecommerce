<x-app-layout>
    <x-container class="px-4 my-8">
        <header class="text-center mb-8">
            <h2 class="flex items-center justify-center gap-2 text-4xl md:text-5xl font-extrabold text-purple-700">
                Política de privacidad
            </h2>
            <p class="mt-1 text-xs text-gray-500">Última actualización: {{ now()->format('d/m/Y') }}</p>
        </header>

        <section class="space-y-6">
            <article class="p-6 bg-white rounded-2xl shadow-lg ring-1 ring-black/5">
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
        </section>
    </x-container>
</x-app-layout>
