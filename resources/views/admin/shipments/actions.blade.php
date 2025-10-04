@if ($shipment->status == \App\Enums\ShipmentStatus::Pendiente)
    <button wire:click="markAsCompleted({{ $shipment->id }})"
        class="underline hover:no-underline text-blue-500 hover:text-blue-700">
        Marcar como entregado
    </button>

    <br>

    <button wire:click="markAsFailed({{ $shipment->id }})"
        class="underline hover:no-underline text-blue-500 hover:text-blue-700">
        Marcar como error en la entrega
    </button>
@endif
