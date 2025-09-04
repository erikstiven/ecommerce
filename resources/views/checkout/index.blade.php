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


    <div class="-mb-16 text-gray-700" x-data="{
        pago: 1,
        mostrarModal: false
    }">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="cols-span-1 bg-white">
                <div class="lg:max-w-[40rem] py-12 px-4 lg:pr-8 sm:pl-6 lg:pl-8 ml-auto">
                    <h1 class="text-2xl font-semibold mb-2">
                        Pago
                    </h1>

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
                                    <i class="fa-regular fa-credit-card text-9xl">
                                    </i>

                                    <p class="mt-2">
                                        Luego de dar click en "Pagar" serás redirigido a la pasarela de pago
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
                                        <p>- BCP: 198-987654321-98</p>
                                        <p>- CCI: 002-198-987654321</p>
                                        <p>- Razón social: Ecommerce S.A.C</p>
                                        <p>- RUC: 20987654321</p>
                                        <p class="mt-3"><strong>2. Pago --</strong></p>
                                        <p>- Cuenta bancaria: RUC 20987654321 - Razón social número <strong>987 654 321</strong> (Ecommerce S.A.C)</p>
                                        <p>
                                            Enviar el comprobante de pago a
                                            <a href="https://wa.me/51987654321" class="text-blue-600 underline"
                                                target="_blank">
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
                    <ul class="space-y-4 mb-4">
                        @foreach (Cart::instance('shopping')->content() as $item)
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
                                    <p class="truncate">
                                        {{ $item->name }}
                                    </p>
                                </div>

                                <div class="flex-shrink-0">
                                    <p>
                                        $./ {{ $item->price }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <hr class="my-3">

                    <div class="flex justify-between mb-2">
                        <p class="text-lg font-semibold">
                            Total
                        </p>
                        <p>
                            $./ {{ number_format(Cart::instance('shopping')->subtotal() + 5, 2) }}
                        </p>
                    </div>

                    <div class="flex justify-between">
                        <p>
                            Subtotal
                        </p>
                        <p>
                            $./ {{ number_format(Cart::instance('shopping')->subtotal(), 2) }}
                        </p>
                    </div>

                    <div class="flex justify-between">
                        <p>
                            Precio de envío
                            <i class="fas fa-info-circle" title="El precio de envío es de $5.00"></i>
                        </p>
                        <p>
                            $./ 5.00
                        </p>
                    </div>


                    <div class="mt-4" x-show="pago == 1">
                        <button @click="mostrarModal = true" class=" btn btn-gradient-purple text-white rounded w-full">
                            Confirmar y Pagar
                        </button>
                    </div>


                </div>
            </div>


        </div>




        <!-- Modal de pago con fondo clickeable y scroll interno -->
        <div x-show="mostrarModal" x-cloak @click.self="mostrarModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm overflow-auto p-4">

            <div class="bg-white p-6 rounded shadow-lg w-full max-w-md text-center">
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

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const buttonContainer = document.getElementById('pp-button');
                if (buttonContainer) {
                    new PPaymentButtonBox({
                        token: '{{ config('services.payphone.token') }}',
                        storeId: '{{ config('services.payphone.store_id') }}',
                        clientTransactionId: 'TX-{{ uniqid() }}',
                        amount: {{ intval((Cart::instance('shopping')->subtotal() + 5) * 100) }},
                        amountWithTax: {{ intval(Cart::instance('shopping')->subtotal() * 100) }},
                        tax: 500,
                        service: 0,
                        tip: 0,
                        currency: "USD",
                        reference: "Pago pedido #{{ session('order_id') ?? uniqid() }}",
                        lang: "es",
                        defaultMethod: "card",
                        timeZone: -5,
                        lat: "-1.831239",
                        lng: "-78.183406",
                        optionalParameter: "Checkout Laravel",
                        phoneNumber: "{{ $telefono }}",
                        documentId: "1234567890",
                        identificationType: 1
                    }).render("pp-button");
                } else {
                    console.error("No se encontró el div con ID 'pp-button'");
                }
            });
        </script>
    @endpush

</x-app-layout>
