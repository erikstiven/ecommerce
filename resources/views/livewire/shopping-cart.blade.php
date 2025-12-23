<div>

    <div class="grid grid-cols-1 lg:grid-cols-7 gap-6">

        <div class="lg:col-span-5">
            <div class="flex justify-between mb-2">
                <h1 class="text-lg">
                    Carrito de compras ({{ Cart::instance('shopping')->count() }} productos)
                </h1>

                <button class="font-semibold text-gray-600 hover:text-purple-400 underline hover:no-under"
                    wire:click="destroy()">
                    Limpiar carrito
                </button>
            </div>

            


            <div class="card-form">

                <ul class="space-y-4">

                    @forelse (Cart::instance('shopping')->content() as $item)
                        @php
                            $itemStock = data_get($item, 'options.stock', 0);
                        @endphp
                        <li class="lg:flex lg:items-center space-y-2 lg:space-y-0 {{ $item->qty > $itemStock ? 'text-red-600' : '' }}">

                            <img class="w-full lg:w-36 aspect-[4/3] object-cover object-center mr-2"
                                src="{{ $item->options->image }}" alt="">
                            <div class="lg:w-64 xl:w-80">

                                @if($item->qty > $itemStock)
                                    <p class="font-semibold text-red-600">
                                        Sin stock
                                    </p>
                                @endif


                                <p class="text-sm truncate">
                                    <a href="{{ route('products.show', $item->id) }}">
                                        {{ $item->name }}
                                    </a>
                                    @php
                                        $features = collect(data_get($item, 'options.features'))->values();
                                    @endphp

                                    @if ($features->isNotEmpty())
                                        <br>
                                        <span class="text-xs text-gray-500">
                                            {{ $features->implode(' | ') }}
                                        </span>
                                    @endif


                                </p>

                                <button
                                    class="bg-red-100 hover:bg-red-200 text-red-800 text-xs font-semibold rounded px-2.5 py-0.5"
                                    wire:click="remove('{{ $item->rowId }}')">
                                    <i class="fa-solid fa-xmark"></i>
                                    Quitar

                                </button>
                            </div>

                            <div class="text-right">
                                <p class="font-semibold">$/. {{ $item->price }}</p>
                                <p class="text-sm text-gray-500">Subtotal: $/. {{ $item->subtotal }}</p>
                            </div>

                            <div class="ml-auto space-x-3">
                                <button class="btn btn-gradient-gray" wire:click="decrease('{{ $item->rowId }}')">
                                    -
                                </button>

                                <span class="inline-block w-2 text-center">
                                    {{ $item->qty }}
                                </span>

                                <button class="btn btn-gradient-gray" 
                                wire:click="increase('{{ $item->rowId }}')"
                                wire:loading.attr="disabled"
                                wire:target="increase('{{ $item->rowId }}')"
                                @disabled($item->qty >= $itemStock)>
                                    +
                                </button>
                            </div>
                        </li>
                    @empty
                        <p class="text-center">No hay productos en el carrito</p>
                    @endforelse


                </ul>
            </div>

        </div>

        <div class="lg:col-span-2">

            <div class="card-form">
                <div class="flex justify-between font-semibold mb-2">
                    <p>
                        Total:
                    </p>

                    <p>
                        $/. {{ $this->subtotal }}
                    </p>

                </div>


                <a href="{{ route('shipping.index') }}" class="btn btn-gradient-purple block w-full text-center">
                    Confirmar compra
                </a>

            </div>

        </div>
    </div>

</div>
