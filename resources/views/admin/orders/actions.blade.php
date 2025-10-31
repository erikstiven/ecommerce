<div class="flex flex-col space-y-2">
    @switch($order->status)
        @case(\App\Enums\OrderStatus::Pendiente)
            <button wire:click="markAsProcessing({{ $order->id }})" class="underline text-blue-500 hover:no-underline">
                Listo para despachar
            </button>
        @break

        @case(\App\Enums\OrderStatus::Procesando)
            <button wire:click="assignDriver({{ $order->id }})" class="underline text-yellow-500 hover:no-underline">
                Asignar repartidor
            </button>
        @break

        {{-- fallido --}}
        @case(\App\Enums\OrderStatus::Fallido)
            <button wire:click="markAsReturned({{ $order->id }})" class="underline text-blue-500 hover:no-underline">
                Marcar como devuelto
            </button>
        @break

        @case(\App\Enums\OrderStatus::Reembolsado)
            <button wire:click="assignDriver({{ $order->id }})" class="underline text-yellow-500 hover:no-underline">
                Asignar repartidor
            </button>
        @break
    @endswitch

    @if ($order->status != \App\Enums\OrderStatus::Cancelado)
        <button wire:click="cancelOrder({{ $order->id }})" class="underline text-red-500 hover:no-underline">
            Cancelar
        </button>
    @endif
</div>
