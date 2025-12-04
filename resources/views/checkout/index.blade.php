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

    {{-- Abre el modal automáticamente cuando $pp exista --}}
    <div class="-mb-16 text-gray-700" x-data="{ pago: 1, mostrarModal: {{ isset($pp) ? 'true' : 'false' }} }">

        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="cols-span-1 bg-white">
                <div class="lg:max-w-[40rem] py-12 px-4 lg:pr-8 sm:pl-6 lg:pl-8 ml-auto">
                    <h1 class="text-2xl font-semibold mb-2">Pago</h1>

                    <div class="shadow rounded-lg overflow-hidden border border-gray-400">
                        <ul class="divide-y divide-gray-400">
                            <li>
                                <label class="p-4 flex items-center">
                                    <input type="radio" value="1" x-model="pago" class="cursor-pointer">
                                    <span class="ml-2">Tarjeta de crédito</span>
                                    <img src="https://codersfree.com/img/payments/credit-cards.png" alt=""
                                        class="h-6 ml-auto">
                                </label>

                                <div class="p-4 bg-gray-100 text-center border-t border-gray-400" x-show="pago == 1">
                                    <i class="fa-regular fa-credit-card text-9xl"></i>
                                    <p class="mt-2">
                                        Luego de dar click en "Pagar" se creará tu orden y se abrirá la pasarela de pago
                                    </p>
                                </div>
                            </li>

                            <li>
                                <label class="p-4 flex items-center">
                                    <input type="radio" value="2" x-model="pago" class="cursor-pointer">
                                    <span class="ml-2">Depósito bancario</span>
                                </label>

                                <div x-show="pago == 2" x-cloak
                                    class="p-4 bg-gray-100 text-sm border-t border-gray-400">
                                    <div class="max-w-md mx-auto space-y-1">
                                        <p><strong>1. Pago por depósito o transferencia bancaria:</strong></p>
                                        <p>- Banco Pichincha</p>
                                        <p>- Cuenta de ahorro transaccional</p>
                                        <p>- Número de cuenta: 2208765620</p>
                                        <p></p>
                                        <p><strong>2. Enviar comprobante de pago:</strong></p>
                                            <input type="button" value="Enviar por WhatsApp">
                                            
                                        <a href="https://wa.me/593979018689?text=Hola%2C%20me%20interesan%20los%20servicios%20y%20productos%20que%20muestran%20en%20su%20p%C3%A1gina%20web." class="text-blue-600 underline"
                                                target="_blank">
                                                +593 97 901 86 89
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
                    <ul class="space-y-4 mb-4">
                        @foreach ($content as $item)
                            <li class="flex items-center space-x-4">
                                <div class="flex-shrink-0 relative">
                                    <img class="h-16 aspect-square" src="{{ $item->options->image }}" alt="">
                                    <div
                                        class="flex justify-center items-center h-6 w-6 bg-gray-900 bg-opacity-70 rounded-full absolute -right-2 -top-2">
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



                    <div class="flex justify-between">
                        <p>Subtotal</p>
                        <p>$./ {{ $subtotal }}</p>
                    </div>

                    <div class="flex justify-between">
                        <p>
                            Precio de envío
                            <i class="fas fa-info-circle" title="El precio de envío es de $5.00"></i>
                        </p>
                        <p>$./ {{ $delivery }}</p>
                    </div>

                    <hr class="my-3">

                    <div class="flex justify-between mb-2 mt-4">
                        <p class="text-lg font-semibold">Total</p>
                        <p>$./ {{ $total }}</p>
                    </div>


                    {{-- El botón crea la orden y vuelve con $pp para abrir la pasarela --}}
                    <div class="mt-4" x-show="pago == 1">
                        <form action="{{ route('checkout.payphone.start') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-gradient-purple text-white rounded w-full">
                                Confirmar y Pagar
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        {{-- Modal de pago --}}
        <div x-show="mostrarModal" x-cloak @click.self="mostrarModal = false"
            class="fixed inset-0 z-50 flex items-start justify-center bg-black bg-opacity-50 backdrop-blur-sm overflow-auto p-4">

            <div class="bg-white p-6 rounded shadow-lg  w-[600px] text-center max-h-[90vh] overflow-y-auto">
                <h2 class="text-xl font-semibold mb-4">¿Confirmar pago?</h2>
                <p class="mb-4">Se abrirá la pasarela PayPhone con el monto final.</p>

                <div id="pp-button"></div>

                <button @click="mostrarModal = false" class="mt-4 text-sm text-gray-600 hover:text-red-500">
                    Cancelar
                </button>
            </div>
        </div>

    </div>

    @push('js')
        {{-- Payphone --}}
        <link rel="stylesheet" href="https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.css">
        <script type="module" src="https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.js"></script>




        @php
            $telefono = Auth::user()?->phone ?? '000000000';
            $telefono = '+593' . ltrim(preg_replace('/[^0-9]/', '', $telefono), '0');
        @endphp

        {{-- Inicializar la cajita SOLO cuando el controlador haya creado la orden y devuelto $pp --}}
        @isset($pp)
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const el = document.getElementById('pp-button');
                    if (!el) {
                        console.error("No se encontró #pp-button");
                        return;
                    }

                    const cfg = {
                        token: '{{ $pp['token'] ?? '' }}',
                        storeId: '{{ $pp['storeId'] ?? '' }}',
                        clientTransactionId: '{{ $pp['clientTransactionId'] ?? '' }}',
                        amount: {{ $pp['amount'] ?? 0 }},
                        amountWithoutTax: {{ $pp['amountWithoutTax'] ?? 0 }},
                        amountWithTax: {{ $pp['amountWithTax'] ?? 0 }},
                        tax: {{ $pp['tax'] ?? 0 }},
                        service: {{ $pp['service'] ?? 0 }},
                        tip: {{ $pp['tip'] ?? 0 }},
                    };
                    console.log('PP cfg:', cfg);

                    if (!cfg.token || !cfg.storeId || !cfg.clientTransactionId || !cfg.amount) {
                        console.error('Parámetros incompletos para PayPhone:', cfg);
                        return;
                    }

                    try {
                        new PPaymentButtonBox({
                            ...cfg,
                            currency: "USD",
                            reference: "Pago pedido #{{ $order->id ?? '' }}",
                            lang: "es",
                            defaultMethod: "card",
                            timeZone: -5,
                            optionalParameter: "Checkout Laravel",
                            phoneNumber: "{{ $telefono }}",
                            documentId: "1234567890",
                            identificationType: 1,
                            responseUrl: "{{ route('payphone.respuesta') }}",
                            cancellationUrl: "{{ route('checkout.index') }}"
                        }).render("pp-button");
                    } catch (e) {
                        console.error('Error inicializando PayPhone ButtonBox:', e);
                    }
                });
            </script>
        @endisset
    @endpush

</x-app-layout>
