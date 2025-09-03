<x-app-layout>

    @if (session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Inicializa Alpine --}}
    <div class="-mb-16 text-gray-700" x-data='{ pago: 1, mostrarModal: @json(isset($pp)) }'>
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="cols-span-1 bg-white">
                <div class="lg:max-w-[40rem] py-12 px-4 lg:pr-8 sm:pl-6 lg:pl-8 ml-auto">
                    <h1 class="text-2xl font-semibold mb-2">Pago</h1>

                    <div class="shadow rounded-lg overflow-hidden border border-gray-400">
                        <ul class="divide-y divide-gray-400">
                            <li>
                                <label class="p-4 flex items-center">
                                    <input type="radio" value="1" x-model="pago" class="cursor-pointer">
                                    <span class="ml-2">Tarjeta de crédito / PayPhone</span>
                                    <img src="https://codersfree.com/img/payments/credit-cards.png" class="h-6 ml-auto">
                                </label>
                                <div class="p-4 bg-gray-100 text-center border-t border-gray-400" x-show="pago == 1">
                                    <i class="fa-regular fa-credit-card text-9xl"></i>
                                    <p class="mt-2">
                                        Luego de dar click en "Confirmar y Pagar" se creará la orden y se abrirá la pasarela de pago (PayPhone).
                                    </p>
                                </div>
                            </li>

                            <li>
                                <label class="p-4 flex items-center">
                                    <input type="radio" value="2" x-model="pago" class="cursor-pointer">
                                    <span class="ml-2">Depósito bancario</span>
                                </label>
                                <div x-show="pago == 2" x-cloak class="p-4 bg-gray-100 text-sm border-t border-gray-400">
                                    <div class="max-w-md mx-auto space-y-1">
                                        <p><strong>1. Pago por depósito o transferencia bancaria:</strong></p>
                                        <p>- BCP: 198-987654321-98</p>
                                        <p>- CCI: 002-198-987654321</p>
                                        <p>- Razón social: Ecommerce S.A.C</p>
                                        <p>- RUC: 20987654321</p>
                                        <p class="mt-3"><strong>2. Enviar el comprobante de pago:</strong></p>
                                        <p>
                                            A WhatsApp:
                                            <a href="https://wa.me/51987654321" class="text-blue-600 underline" target="_blank">
                                                987 654 321
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="cols-span-1">
                <div class="lg:max-w-[40rem] py-12 px-4 lg:pl-8 sm:pr-6 lg:pr-8 mr-auto">

                    {{-- Cálculo de montos seguros --}}
                    @php
                        $subtotalStr = (string) (Cart::instance('shopping')->subtotal(2, '.', '') ?? '0');
                        $subtotal = (float) preg_replace('/[^\d\.]/', '', $subtotalStr);
                        $shipping = 5.00;
                        $total = $subtotal + $shipping;

                        // Valores para PayPhone si no usas controlador
                        $ppAmount = (int) round($total * 100);
                        $ppAmountW = (int) round($subtotal * 100);
                        $ppTax = (int) round($shipping * 100);
                    @endphp

                    {{-- Productos --}}
                    <ul class="space-y-4 mb-4">
                        @foreach (Cart::instance('shopping')->content() as $item)
                            <li class="flex items-center space-x-4">
                                <div class="flex-shrink-0 relative">
                                    <img class="h-16 aspect-square" src="{{ $item->options->image }}" alt="">
                                    <div class="flex justify-center items-center h-6 w-6 bg-gray-900 bg-opacity-70 rounded-full absolute -right-2 -top-2">
                                        <span class="text-white font-semibold">
                                            {{ $item->qty }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="truncate">{{ $item->name }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p>$./ {{ $item->price }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <hr class="my-3">

                    <div class="flex justify-between mb-2">
                        <p class="text-lg font-semibold">Total</p>
                        <p>$./ {{ number_format($total, 2) }}</p>
                    </div>

                    <div class="flex justify-between">
                        <p>Subtotal</p>
                        <p>$./ {{ number_format($subtotal, 2) }}</p>
                    </div>

                    <div class="flex justify-between">
                        <p>Precio de envío <i class="fas fa-info-circle" title="El precio de envío es de $5.00"></i></p>
                        <p>$./ {{ number_format($shipping, 2) }}</p>
                    </div>

                    {{-- Pago con PayPhone --}}
                    <div class="mt-4" x-show="pago == 1">
                        <form method="POST" action="{{ route('checkout.payphone.start') }}">
                            @csrf
                            <button type="submit" class="btn btn-gradient-purple text-white rounded w-full">
                                Confirmar y Pagar con PayPhone
                            </button>
                        </form>
                    </div>

                    {{-- Pago por Depósito --}}
                    <div class="mt-4" x-show="pago == 2" x-cloak>
                        <form method="POST" action="{{ route('checkout.deposit') }}" enctype="multipart/form-data">
                            @csrf
                            <label class="block text-sm font-medium text-gray-700 mb-1">Adjuntar comprobante</label>
                            <input name="deposit_proof" type="file" accept="image/*,.pdf" class="block w-full text-sm" required>
                            <button type="submit" class="btn btn-gradient-purple text-white rounded w-full mt-3">
                                Confirmar y Generar Orden
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        {{-- Modal PayPhone --}}
        <div x-show="mostrarModal" x-cloak @click.self="mostrarModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm overflow-auto p-4">
            <div class="bg-white p-6 rounded shadow-lg w-full max-w-md text-center">
                <h2 class="text-xl font-semibold mb-4">Pasarela de pago</h2>
                <p class="mb-4">Si ves el botón, procede a completar el pago en PayPhone.</p>
                <div id="pp-button" class="mx-auto"></div>
                <button @click="mostrarModal = false" class="mt-4 text-sm text-gray-600 hover:text-red-500">Cerrar</button>
            </div>
        </div>
    </div>

    {{-- Scripts y lógica para PayPhone --}}
    @push('js')
        @php
            $ppToken   = $pp['token']   ?? null;
            $ppStoreId = $pp['storeId'] ?? null;
            $ppClient  = $pp['clientTransactionId'] ?? null;
            $ppAmount  = $pp['amount']  ?? $ppAmount;
            $ppAmountW = $pp['amountWithTax'] ?? $ppAmountW;
            $ppTax     = $pp['tax'] ?? $ppTax;

            $telefono = Auth::user()?->phone ?? '000000000';
            $telefono = '+593' . ltrim(preg_replace('/[^0-9]/', '', $telefono), '0');
        @endphp

        @if ($ppToken && $ppStoreId && $ppClient && $ppAmount)
            <link rel="stylesheet" href="https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.css">
            <script type="module" src="https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    try {
                        new PPaymentButtonBox({
                            token: @json($ppToken),
                            storeId: @json($ppStoreId),
                            clientTransactionId: @json($ppClient),
                            amount: @json($ppAmount),
                            amountWithTax: @json($ppAmountW),
                            tax: @json($ppTax),
                            service: 0,
                            tip: 0,
                            currency: "USD",
                            reference: "Pago pedido #{{ $order->id ?? '' }}",
                            lang: "es",
                            timeZone: -5,
                            lat: "-1.831239",
                            lng: "-78.183406",
                            optionalParameter: "Checkout Laravel",
                            phoneNumber: @json($telefono),
                            documentId: "1234567890",
                            identificationType: 1
                        }).render("pp-button");
                    } catch (err) {
                        console.warn('PayPhone UI no disponible', err);
                    }
                });
            </script>
        @endif
    @endpush

</x-app-layout>
