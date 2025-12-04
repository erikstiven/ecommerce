<?php

namespace App\Livewire\Admin\Orders;

use App\Enums\OrderStatus;
use App\Enums\ShipmentStatus;
use App\Models\Driver;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Support\Facades\Storage;

class OrderTable extends DataTableComponent
{
    protected $model = Order::class;

    public $drivers;

    public $new_shipment = [
        'openModal' => false,
        'order_id' => '',
        'driver_id' => '',
    ];

    public function mount()
    {
        $this->drivers = Driver::all();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTheme('tailwind');
    }

    public function columns(): array
    {
        return [
            Column::make("No. Orden", "id")
                ->sortable()->searchable(),

            Column::make("Ticket")
                ->label(function ($row) {
                    return view('admin.orders.ticket', ['order' => $row]);
                }),

            Column::make("F. Orden", "created_at")
                ->format(function ($value) {
                    return $value->format('d/m/Y');
                })
                ->sortable()->searchable(),

            Column::make("total")
                ->format(function ($value) {
                    return '$' . number_format($value, 2);
                })
                ->sortable()->searchable(),

            Column::make("Cantidad", "content")
                ->format(function ($value) {
                    return count($value);
                })
                ->sortable()->searchable(),

            Column::make("Estado", "status")
                ->format(function ($value) {
                    return $value->name;
                })
                ->sortable()->searchable(),

            Column::make("Acciones", "id")
                ->label(function ($row) {
                    return view('admin.orders.actions', ['order' => $row]);
                })

        ];
    }

    public function downloadTicket(Order $order)
    {
        return Storage::download($order->pdf_path);
    }

    public function markAsProcessing(Order $order)
    {
        $order->status = OrderStatus::Procesando;
        $order->save();
    }
    //custom view
    public function customView(): string
    {
        return 'admin.orders.modal';
    }
    //assing driver
    // public function assingDriver(Order $order)
    // {
    //     $this->new_shipment['order_id'] = $order->id;
    //     $this->new_shipment['openModal'] = true;
    // }
    public function assignDriver(Order $order)
    {
        $this->new_shipment['order_id'] = $order->id;
        $this->new_shipment['openModal'] = true;
    }

    //save shipment
    public function saveShipment()
    {
        $this->validate([
            'new_shipment.driver_id' => 'required|exists:drivers,id',
        ]);

        $order = Order::find($this->new_shipment['order_id']);
        $order->status = OrderStatus::Enviado;

        $order->save();

        $order->shipments()->create([
            'driver_id' => $this->new_shipment['driver_id'],
        ]);

        $this->reset('new_shipment');
    }
    //markAsReturned
    public function markAsReturned(Order $order)
    {
        $order->status = OrderStatus::Reembolsado;
        $order->save();

        //$shipment = $order->shipments()->lasted();
        $shipment = $order->shipments()->latest()->first();

        $shipment->refunded_at = now();
        $shipment->save();
    }
    //cancelOrder
    public function cancelOrder(Order $order)
    {

        if ($order->status === OrderStatus::Enviado) {
            $this->dispatch('swal', [
                'title' => 'No se puede cancelar',
                'text' => 'La orden tiene envios pendientes',
                'icon' => 'error',
            ]);
            return;
        }

        if ($order->status === OrderStatus::Fallido) {
            $this->dispatch('swal', [
                'title' => 'No se puede cancelar',
                'text' => 'El pedido a sido reembolsado por el delivery',
                'icon' => 'error',
            ]);
            return;
        }
        $order->status = OrderStatus::Cancelado;
        $order->save();
    }
}
