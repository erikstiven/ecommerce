<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\CheckboxColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\Column;

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

    public function updatedSelected(): void
    {
        $this->dispatchSelectionCount();
    }

    public function columns(): array
    {
        return [
            CheckboxColumn::make(),
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

        $this->pruneSelection([$id]);

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Producto eliminado',
            'text'  => 'El producto se eliminó correctamente.',
        ]);
    }

    public function deleteSelected()
    {
        $selectedIds = collect($this->selected ?? [])->filter()->all();

        if (empty($selectedIds)) {
            return;
        }

        $products = Product::whereIn('id', $selectedIds)->get();

        foreach ($products as $product) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            $product->delete();
        }

        $this->clearSelection();

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Productos eliminados',
            'text'  => 'Los elementos seleccionados se eliminaron correctamente.',
        ]);
    }

    protected function dispatchSelectionCount(): void
    {
        $this->dispatch('selection-updated', count: count($this->selected ?? []));
    }

    protected function clearSelection(): void
    {
        $this->selected = [];
        $this->dispatchSelectionCount();
    }

    protected function pruneSelection(array $ids): void
    {
        if (!isset($this->selected)) {
            return;
        }

        $this->selected = array_values(array_diff($this->selected, $ids));
        $this->dispatchSelectionCount();
    }
}
