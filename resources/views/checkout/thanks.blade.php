<x-app-layout>
    <div class="p-20 max-w-3xl mx-auto">

        <h1 class="text-3xl font-bold mb-4 text-center text-green-700">🎉 ¡Gracias por tu compra!  🎉</h1>

        @if (session('pago_estado') === 'Approved' && isset($order))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                ¡Pago aprobado correctamente!
            </div>

            <div class="bg-white shadow rounded-lg p-4 mb-6">
                <h2 class="text-xl font-semibold mb-2">Resumen de tu compra</h2>

                <p class="text-sm text-gray-600 mb-4">Número de orden: {{ $order->id }}</p>

                <ul class="divide-y divide-gray-200">
                    @foreach ($order->items as $item)
                        <li class="py-2 flex justify-between items-center">
                            <div>
                                <p class="font-medium">{{ $item->product_title }}</p>
                                <p class="text-sm text-gray-500">Cantidad: {{ $item->qty }}</p>
                            </div>
                            <div class="text-right">
                                <p>${{ number_format($item->unit_price, 2) }} c/u</p>
                                <p class="text-sm">Subtotal: ${{ number_format($item->line_total, 2) }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <hr class="my-4">

                <div class="flex justify-between text-lg font-semibold">
                    <span>Subtotal:</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-lg">
                    <span>Envío:</span>
                    <span>${{ number_format($order->shipping_cost, 2) }}</span>
                </div>
                <div class="flex justify-between text-xl font-bold mt-2 text-purple-700">
                    <span>Total pagado:</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </div>

                @if (is_array($order->address))
                    <hr class="my-4">
                    <h3 class="text-lg font-semibold mb-2">Dirección de envío</h3>
                    <p class="text-sm text-gray-600">{{ $order->address['province'] ?? '' }}, {{ $order->address['city'] ?? '' }}</p>
                    <p class="text-sm text-gray-600">{{ $order->address['description'] ?? '' }}</p>
                    @if (isset($order->address['receiver_info']) && is_array($order->address['receiver_info']))
                        <p class="text-sm text-gray-600">Recibe: {{ $order->address['receiver_info']['name'] ?? '' }} {{ $order->address['receiver_info']['last_name'] ?? '' }}</p>
                        <p class="text-sm text-gray-600">Teléfono: {{ $order->address['receiver_info']['phone'] ?? '' }}</p>
                    @endif
                @endif
            </div>
        @elseif (session('pago_estado'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                Error: {{ session('pago_estado') }}
            </div>
        @else
            <div class="bg-gray-100 p-4 mb-6">
                ℹNo hay información disponible del pago.
            </div>
        @endif

        <div class="text-center mt-6">
            <a href="/"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Volver al inicio
            </a>
        </div>

    </div>
</x-app-layout>
