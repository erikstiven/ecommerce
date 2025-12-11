<?php

namespace App\Livewire\Admin\Shipments;

use App\Enums\OrderStatus;
use App\Enums\ShipmentStatus;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use App\Models\Shipment;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Columns\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\TextColumn;

class ShipmentTable extends DataTableComponent
{
    protected $model = Shipment::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTheme('tailwind');
    }

    public function columns(): array
    {
        return [
            TextColumn::make("Id", "id")
                ->sortable(),
            TextColumn::make("No. Orden", "order_id")
                ->sortable(),
            TextColumn::make("Conductor", "driver.user.name")
                ->sortable(),

            TextColumn::make("Placa", "driver.plate_number")
                ->sortable(),

            TextColumn::make("Status", "status")
                ->format(function ($value) {
                    return $value->name;
                })
                ->sortable(),

            //acciones
            Column::make("actions")
                ->label(function ($row) {
                    return view('admin.shipments.actions', [
                        'shipment' => $row
                    ]);
                })


        ];
    }
    //filters
    public function filters(): array
    {
        return [
            SelectFilter::make('Status')
                ->options([
                    '' => 'Todos',
                    1 => 'Pendiente',
                    2 => 'Completado',
                    3 => 'Fallido',
                ])->filter(function ($query, $value) {
                    $query->where('status', $value);
                }),
        ];
    }

    //markAsCompleted
    public function markAsCompleted(Shipment $shipment)
    {
        $shipment->status = ShipmentStatus::Completado;
        $shipment->delivered_at = now();
        $shipment->save();

        $order = $shipment->order;
        $order->status = OrderStatus::Completado;
        $order->save();
    }

    //markAsFailed
    public function markAsFailed(Shipment $shipment)
    {
        $shipment->status = ShipmentStatus::Fallido;
        $shipment->save();

        $order = $shipment->order;
        $order->status = OrderStatus::Fallido;
        $order->save();
    }
}
