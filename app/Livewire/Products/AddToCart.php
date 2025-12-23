<?php

namespace App\Livewire\Products;

use App\Models\Feature;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

/**
 * Componente Livewire para añadir productos al carrito teniendo en cuenta variantes y stock.
 */
class AddToCart extends Component
{
    /** @var \App\Models\Product */
    public $product;
    /** @var \App\Models\Variant|null Variante seleccionada según las características */
    public $variant;
    /** Cantidad solicitada */
    public $qty = 1;
    /** Stock disponible de la variante */
    public $stock;
    /** Características seleccionadas por el usuario */
    public $selectedFeatures = [];

    /**
     * Inicializa el componente asignando las características por defecto y obteniendo la variante inicial.
     */
    public function mount()
    {
        if ($this->product->variants->isNotEmpty()) {
            // Selecciona las características de la primera variante por defecto
            $this->selectedFeatures = $this->product->variants
                ->first()
                ->features
                ->pluck('id', 'option_id')
                ->toArray();

            $this->getvariant();
        } else {
            $this->variant = null;
            $this->stock   = 0;
            $this->qty     = 1;
        }
    }

    /**
     * Se ejecuta al modificar las características seleccionadas para recalcular la variante.
     */
    public function updatingSelectedFeatures()
    {
        $this->getvariant();
    }

    /**
     * Busca y asigna la variante actual en función de las características seleccionadas.
     */
    public function getvariant()
    {
        if (!$this->product?->variants || empty($this->selectedFeatures)) {
            $this->variant = null;
            $this->stock   = 0;
            return;
        }

        $this->variant = $this->product->variants
            ->filter(function ($variant) {
                return !array_diff(
                    $variant->features()->pluck('features.id')->toArray(),
                    $this->selectedFeatures
                );
            })
            ->first();

        if (!$this->variant) {
            $this->stock = 0;
            $this->qty   = 1;
            return;
        }

        $this->stock = $this->variant->stock ?? 0;
        $this->qty   = 1;
    }

    /**
     * Añade el producto al carrito validando el stock disponible.
     */
    public function add_to_cart()
    {
        $cart = Cart::instance('shopping');

        // Verificar que exista una variante y que tenga stock disponible
        if (!$this->variant || $this->stock <= 0) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => '¡Lo siento!',
                'text'  => 'No hay stock disponible para esta variante.',
            ]);
            return;
        }

        // Buscar si ya hay un item con la misma SKU en el carrito
        $cartItem = $cart->search(function ($cartItem) {
            return $cartItem->options->sku === $this->variant->sku;
        })->first();

        // Stock disponible considerando unidades en el carrito
        $availableStock = $this->stock;
        if ($cartItem) {
            $availableStock -= $cartItem->qty;
        }

        // Validar que la cantidad solicitada no supere el stock disponible
        if ($this->qty > $availableStock) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => '¡Lo siento!',
                'text'  => 'No hay suficiente stock disponible',
            ]);
            return;
        }

        // Agregar al carrito con los datos y opciones necesarias
        $cart->add([
            'id'    => $this->product->id,
            'name'  => $this->product->name,
            'qty'   => $this->qty,
            'price' => $this->product->price,
            'options' => [
                'sku'      => $this->variant->sku,
                'image'    => $this->product->image,
                'stock'    => $this->variant->stock,
                'features' => Feature::whereIn('id', $this->selectedFeatures)
                    ->pluck('description', 'id')
                    ->toArray(),
            ],
            'tax' => 18,
        ])->associate(Product::class);

        // Guardar el carrito para el usuario autenticado
        if (Auth::check()) {
            $cart->store(Auth::id());
        }

        // Actualizar contador del carrito y notificar éxito
        $this->dispatch('cartUpdated', $cart->count());

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'Producto agregado al carrito de compras',
        ]);
    }

    /**
     * Renderiza la vista del componente.
     */
    public function render()
    {
        return view('livewire.products.add-to-cart');
    }
}
