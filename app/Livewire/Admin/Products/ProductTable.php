<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ProductTable extends DataTableComponent
{
    protected $model = Product::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable()->searchable(),
            Column::make('SKU', 'sku')->sortable()->searchable(),
            Column::make('Nombre', 'name')->sortable()->searchable(),
            Column::make('Precio', 'price')
                ->format(fn($value) => '$' . number_format($value, 2))
                ->sortable()
                ->searchable(),
            Column::make('Acciones', 'id')
                ->label(fn($row) => view('admin.products.actions', ['product' => $row])),
        ];
    }
}
