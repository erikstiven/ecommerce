<x-app-layout>
    <x-container class="mt-12">
        <div class="grid grid-cols-3  gap-6">

            <div class="col-span-2">

                @livewire('shipping-addresses')

            </div>

            <div class="col-span-1">

                <div class="bg-white rounded-lg shadow overflow-hidden mb-4">
                    <div class="bg-purple-600 text-white p-4 flex items-center justify-between">
                        <p class="font-semibold">
                            Resumen de Compra ({{ Cart::instance('shopping')->count() }})
                        </p>

                        <a href="{{ route('cart.index') }}">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>

                    </div>

                    <div class="p-4 text-gray-600">
                        <ul>
                            @foreach (Cart::instance('shopping')->content() as $item)
                                <li class="flex items-center space-x-4">
                                    <figure class="shrink-0">
                                        <img src="{{ $item->options->image }}"
                                            class="h-12 aspect-square object-cover rounded">
                                    </figure>

                                    <div class="flex-1 min-w-0">
                                        <p class="truncate text-sm max-w-[240px]" title="{{ $item->name }}">
                                            {{ $item->name }}
                                        </p>

                                        <p class="text-sm text-gray-600">
                                            $/. {{ $item->price }}
                                        </p>
                                    </div>

                                    <div class="shrink-0 text-sm font-semibold text-gray-700">
                                        {{ $item->qty }}
                                    </div>
                                </li>
                            @endforeach

                        </ul>

                        <hr class="my-4 ">

                        <div class="flex justify-between">
                            <p class="text-lg font-semibold">
                                Total
                            </p>
                            <p class="text-lg font-semibold">
                                $/. {{ Cart::instance('shopping')->subtotal() }}
                            </p>


                        </div>

                    </div>

                </div>

                <a href="{{ route('checkout.index') }}"  class="btn btn-gradient-purple hover:bg-purple-800 block w-full text-center">
                    Siguiente
                </a>

            </div>

        </div>


    </x-container>

</x-app-layout>
