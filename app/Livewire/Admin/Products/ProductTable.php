<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ProductTable extends DataTableComponent
{
    protected $model = Product::class;

    // Indica que escuchamos el evento deleteProduct
    protected $listeners = ['deleteProduct'];

    public function render(): \Illuminate\Contracts\View\View
    {
        $this->dispatch('refreshIcons'); // 🔁 Dispara el evento JS en cada render
        return parent::render();
    }



    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTheme('tailwind');
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
            Column::make('Acciones')
                ->label(fn($row) => view('admin.products.actions', ['product' => $row]))
                ->html()
                ->collapseOnTablet(),    
        ];
    }

    // Aquí se procesa la eliminación del producto al recibir el evento
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        // Borra la imagen del disco si existe
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        // Elimina el producto de la base de datos
        $product->delete();

        // Opcional: muestra notificación SweetAlert en la interfaz
        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => '¡Producto eliminado!',
            'text'  => 'El producto se eliminó correctamente.',
        ]);
    }
}
