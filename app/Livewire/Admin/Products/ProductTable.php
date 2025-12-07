<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ProductTable extends DataTableComponent
{
    protected $model = Product::class;

    // IDs seleccionados
    public array $selected = [];

    protected $listeners = ['deleteProduct', 'toggleSelectAll', 'deleteSelected'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTheme('tailwind');
    }

    public function toggleSelectAll()
    {
        $all = Product::pluck('id')->toArray();

        // Si todos están seleccionados → limpiar
        if (count($this->selected) === count($all)) {
            $this->selected = [];
            return;
        }

        // Si no → seleccionar todos
        $this->selected = $all;
    }

    public function columns(): array
    {
        return [
            // Checkbox manual (sin header)
            Column::make('Sel.')
                ->label(fn($row) => view('admin.products.checkbox', ['row' => $row]))
                ->html(),

            Column::make('ID', 'id')->sortable()->searchable(),
            Column::make('SKU', 'sku')->sortable()->searchable(),
            Column::make('Nombre', 'name')->sortable()->searchable(),

            Column::make('Precio', 'price')
                ->format(fn($value) => '$' . number_format($value, 2))
                ->sortable()
                ->searchable(),

            Column::make('Acciones')
                ->label(fn($row) => view('admin.products.actions', ['product' => $row]))
                ->html(),
        ];
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Producto eliminado',
            'text'  => 'El producto se eliminó correctamente.',
        ]);
    }

    public function getHasSelectedProperty()
    {
        return count($this->selected) > 0;
    }


    public function deleteSelected()
    {
        if (empty($this->selected)) {
            return;
        }

        $products = Product::whereIn('id', $this->selected)->get();

        foreach ($products as $product) {

            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            $product->delete();
        }

        $this->selected = []; // limpiar selección

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Productos eliminados',
            'text'  => 'Los elementos seleccionados se eliminaron correctamente.',
        ]);
    }
}
