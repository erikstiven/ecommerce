<div>
    <section class="bg-white rounded-lg shadow overflow-hidden ">
        <header class="bg-gray-900 px-4 py-2">
            <h2 class="text-white text-lg">Direcciones de envío guardadas</h2>
        </header>

        <div class="p-4">
            @if ($newAddress)

                <x-validation-errors class="mb-6" />

                <div class="grid grid-cols-4 gap-4">
                    {{-- Tipo de dirección --}}
                    <div class="col-span-1">
                        <x-select wire:model.live="createAddress.type"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="" disabled selected>Tipo de dirección</option>
                            <option value="1">Domicilio</option>
                            <option value="2">Oficina</option>
                        </x-select>

                    </div>

                    {{-- Nombre de la dirección --}}
                    <div class="col-span-3">
                        <x-input class="w-full" wire:model.live="createAddress.description"
                            placeholder="Nombre de la dirección" />
                    </div>

                    {{-- Provincia --}}
                    <div class="col-span-2">
                        <x-input class="w-full" wire:model.live="createAddress.province" placeholder="Provincia" />
                    </div>
                    {{-- Ciudad --}}
                    <div class="col-span-2">
                        <x-input class="w-full" wire:model.live="createAddress.city" placeholder="Ciudad" />
                    </div>


                    {{-- Referencia --}}
                    <div class="col-span-4">
                        <x-input class="w-full" wire:model.live="createAddress.reference" placeholder="Referencia" />
                    </div>
                </div>

                <hr class="my-4">

                {{-- ¿Quién recibirá el pedido? --}}
                <div x-data="{
                    receiver: @entangle('createAddress.receiver'),
                    receiver_info: @entangle('createAddress.receiver_info')
                
                
                }"
                    x-init ="
                $watch('receiver', value => {
                    if (value == 1) {
                        receiver_info.name = '{{ auth()->user()->name }}';
                        receiver_info.last_name = '{{ auth()->user()->last_name }}';
                        receiver_info.document_type = '{{ auth()->user()->document_type }}';
                        receiver_info.document_number = '{{ auth()->user()->document_number }}';
                        receiver_info.phone = '{{ auth()->user()->phone }}';
                    } else {
                        receiver_info.name = '';
                        receiver_info.last_name = '';
                        receiver_info.document_type = '';
                        receiver_info.document_number = '';
                        receiver_info.phone = '';
                    }
                })
                ">
                    <p class="font-semibold mb-2">
                        ¿Quién recibirá el pedido?
                    </p>

                    <div class="flex space-x-4 mb-4">
                        <label class="flex items-center">
                            <input x-model="receiver" type="radio" value="1" class="mr-2" />
                            Seré yo
                        </label>
                        <label class="flex items-center">
                            <input x-model="receiver" type="radio" value="2" class="mr-2" />
                            Otra persona
                        </label>
                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.name" class="w-full"
                                placeholder="Nombres" />
                        </div>

                        <div>
                            <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.last_name" class="w-full"
                                placeholder="Apellidos" />
                        </div>

                        <div>
                            <div class="flex space-x-2">
                                <x-select x-model="receiver_info.document_type">
                                    <option value="" disabled>Tipo de documento</option>
                                    @foreach (\App\Enums\TypeOfDocuments::cases() as $item)
                                        <option value="{{ $item->value }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach

                                </x-select>

                                <x-input x-model="receiver_info.document_number" class="w-full"
                                    placeholder="Número de documento" />
                            </div>
                        </div>

                        <div>
                            <x-input x-model="receiver_info.phone" class="w-full" placeholder="Teléfono" />

                        </div>

                        <div>

                            <button class="w-full btn-gradient-red" wire:click= "set('newAddress', false)">
                                Cancelar

                            </button>

                        </div>

                        <div>
                            <button class="w-full btn-gradient-green" wire:click= "store">
                                Guardar
                            </button>

                        </div>


                    </div>

                </div>
            @else
                @if ($editAddress->id)
                    <p>
                        <x-validation-errors class="mb-6" />

                    <div class="grid grid-cols-4 gap-4">
                        {{-- Tipo de dirección --}}
                        <div class="col-span-1">
                            <x-select wire:model.live="editAddress.type"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="" disabled>Tipo de dirección</option>
                                <option value="1">Domicilio</option>
                                <option value="2">Oficina</option>
                            </x-select>

                        </div>

                        {{-- Nombre de la dirección --}}
                        <div class="col-span-3">
                            <x-input class="w-full" wire:model.live="editAddress.description"
                                placeholder="Nombre de la dirección" />
                        </div>

                        {{-- Provincia --}}
                        <div class="col-span-2">
                            <x-input class="w-full" wire:model.live="editAddress.province" placeholder="Provincia" />
                        </div>
                        {{-- Ciudad --}}
                        <div class="col-span-2">
                            <x-input class="w-full" wire:model.live="editAddress.city" placeholder="Ciudad" />
                        </div>


                        {{-- Referencia --}}
                        <div class="col-span-4">
                            <x-input class="w-full" wire:model.live="editAddress.reference" placeholder="Referencia" />
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- ¿Quién recibirá el pedido? --}}
                    <div x-data="{
                        receiver: @entangle('editAddress.receiver'),
                        receiver_info: @entangle('editAddress.receiver_info')
                    
                    
                    }"
                        x-init ="
                $watch('receiver', value => {
                    if (value == 1) {
                        receiver_info.name = '{{ auth()->user()->name }}';
                        receiver_info.last_name = '{{ auth()->user()->last_name }}';
                        receiver_info.document_type = '{{ auth()->user()->document_type }}';
                        receiver_info.document_number = '{{ auth()->user()->document_number }}';
                        receiver_info.phone = '{{ auth()->user()->phone }}';
                    } else {
                        receiver_info.name = '';
                        receiver_info.last_name = '';
                        receiver_info.document_type = '';
                        receiver_info.document_number = '';
                        receiver_info.phone = '';
                    }
                })
                ">
                        <p class="font-semibold mb-2">
                            ¿Quién recibirá el pedido?
                        </p>

                        <div class="flex space-x-4 mb-4">
                            <label class="flex items-center">
                                <input x-model="receiver" type="radio" value="1" class="mr-2" />
                                Seré yo
                            </label>
                            <label class="flex items-center">
                                <input x-model="receiver" type="radio" value="2" class="mr-2" />
                                Otra persona
                            </label>
                        </div>

                        <div class="grid grid-cols-2 gap-4">

                            <div>
                                <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.name" class="w-full"
                                    placeholder="Nombres" />
                            </div>

                            <div>
                                <x-input x-bind:disabled="receiver == 1" x-model="receiver_info.last_name"
                                    class="w-full" placeholder="Apellidos" />
                            </div>

                            <div>
                                <div class="flex space-x-2">
                                    <x-select x-model="receiver_info.document_type">
                                        <option value="" disabled>Tipo de documento</option>
                                        @foreach (\App\Enums\TypeOfDocuments::cases() as $item)
                                            <option value="{{ $item->value }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach

                                    </x-select>

                                    <x-input x-model="receiver_info.document_number" class="w-full"
                                        placeholder="Número de documento" />
                                </div>
                            </div>

                            <div>
                                <x-input x-model="receiver_info.phone" class="w-full" placeholder="Teléfono" />

                            </div>

                            <div>

                                <button class="w-full btn-gradient-red" wire:click= "set('editAddress.id', null)">
                                    Cancelar

                                </button>

                            </div>

                            <div>
                                <button class="w-full btn-gradient-green" wire:click= "update()">
                                    Actualizar
                                </button>

                            </div>


                        </div>

                    </div>
                    </p>
                @else
                    @if ($addresses->count())
                        {{-- Mostrar direcciones existentes si hay --}}
                        <ul class="grid grid-cols-3 gap-4">
                            @foreach ($addresses as $address)
                                <li @class([
                                    'rounded-lg shadow-lg p-4',
                                    'bg-gray-300' => (bool) $address->default,
                                    'bg-white' => !(bool) $address->default,
                                ]) wire:key="address-{{ $address->id }}">

                                    <div class="p-4 flex items-center">

                                        <div>
                                            <i class="fa-solid fa-house text-xl "></i>
                                        </div>
                                        <div class="flex-1 mx-4 text-xs">

                                            <p class="text-purple-600">
                                                {{ $address->type == 1 ? 'Domicilio' : 'Oficina' }}
                                            </p>

                                            <p class="text-gray-800 font-semibold">
                                                {{ $address->province }}, {{ $address->city }}

                                            </p>
                                            <p class="text-gray-600 font-semibold">
                                                {{ $address->description }}
                                            </p>

                                            <p class="text-gray-600 font-semibold">
                                                {{ $address->receiver_info['name'] }}

                                            </p>

                                        </div>
                                        <div class="text-xs text-gray-800 flex flex-col">
                                            <button wire:click="setDefaultAddress({{ $address->id }})">
                                                <i class="fa-solid fa-star"></i>
                                            </button>
                                            <button wire:click="edit({{ $address->id }})">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>
                                            <button wire:click="deleteAddress({{ $address->id }})">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>

                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center">No hay direcciones de envío guardadas</p>
                    @endif

                    <button class="btn-gradient-gray w-full flex items-center justify-center mt-4"
                        wire:click="$set('newAddress', true)">
                        Agregar <i class="fa-solid fa-plus ml-2"></i>
                    </button>

                @endif
            @endif
        </div>
    </section>
</div>
