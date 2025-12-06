<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ProductTable extends DataTableComponent
{
    protected $model = Product::class;

    // Checkboxes seleccionados
    public array $selected = [];

    public function toggleSelectAll()
    {
        // Si hay todos seleccionados → desmarcar todos
        if (count($this->selected) === Product::count()) {
            $this->selected = [];
            return;
        }

        // Si no → seleccionar TODOS
        $this->selected = Product::pluck('id')->toArray();
    }

    protected $listeners = ['deleteProduct'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTheme('tailwind');
    }

    public function columns(): array
    {
        return [
            // Columna de checkbox manual
            Column::make('Sel.')
            ->label(fn($row) => view('admin.products.checkbox', ['row' => $row]))
            ->html()
            ->header(view('admin.products.checkbox-header')),

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

    // Eliminación masiva
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

        $this->selected = [];

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Productos eliminados',
            'text'  => 'Los elementos seleccionados se eliminaron correctamente.',
        ]);
    }
}
