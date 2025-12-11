<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\TextColumn;

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

        $this->setConfigurableAreas([
            'toolbar-left-start' => 'admin.categories.toolbar',
        ]);
    }

    public function updatedSelected(): void
    {
        $this->dispatchSelectionCount();
    }

    public function columns(): array
    {
        $headerCheckbox = view('admin.categories.checkbox-header')->render();

        return [
            Column::make($headerCheckbox)
                ->label(fn($row) => view('admin.categories.checkbox', ['row' => $row]))
                ->html()
                ->excludeFromColumnSelect(),
            TextColumn::make('ID', 'id')->sortable()->searchable(),
            TextColumn::make('SKU', 'sku')->sortable()->searchable(),
            TextColumn::make('Nombre', 'name')->sortable()->searchable(),

            TextColumn::make('Precio', 'price')
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

        $this->selected = array_values(array_diff($this->getSelected(), [$id]));
        $this->dispatchSelectionCount();

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Producto eliminado',
            'text'  => 'El producto se eliminó correctamente.',
        ]);
    }

    public function deleteSelected()
    {
        $selectedIds = $this->getSelected();

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

        $this->clearSelected();

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

    public function getSelected(): array
    {
        return array_values(collect($this->selected ?? [])->filter()->all());
    }

    public function clearSelected(): void
    {
        $this->selected = [];
        $this->dispatchSelectionCount();
    }

}
