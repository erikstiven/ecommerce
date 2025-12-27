<x-app-layout>
    <x-container class="px-4 my-8">
        <header class="text-center mb-8">
            <h2 class="flex items-center justify-center gap-2 text-4xl md:text-5xl font-extrabold text-purple-700">
                Términos y condiciones
            </h2>
            <p class="mt-1 text-xs text-gray-500">Última actualización: {{ now()->format('d/m/Y') }}</p>
        </header>

        <section class="space-y-6">
            <article class="p-6 bg-white rounded-2xl shadow-lg ring-1 ring-black/5">
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
        </section>
    </x-container>
</x-app-layout>
