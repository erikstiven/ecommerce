<?php

namespace App\Livewire\Products;

use App\Models\Feature;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Illuminate\Support\Facades\Auth; //

class AddToCart extends Component
{

    public $product;

    public $variant;

    public $qty = 1;

    public $stock;

    public $selectedFeatures = [];




    //mount
    public function mount()
    {

        $this->selectedFeatures = $this->product->variants->first()->features->pluck('id', 'option_id')->toArray();
        $this->getvariant();
    }
    //update
    // public function update($name, $value)
    // {
    //     if ($name == 'selectedFeatures') {
    //         $this->selectedFeatures = array_merge($this->selectedFeatures, $value);
    //         $this->getvariant();
    //     }
    // }

    public function updatingSelectedFeatures()
    {
        $this->getvariant();
    }

    //public variant
    public function getvariant()
    {
        if (!$this->product?->variants || empty($this->selectedFeatures)) {
            return null;
        }

        $this->variant = $this->product->variants
            ->filter(function ($variant) {
                return !array_diff(
                    $variant->features()->pluck('features.id')->toArray(),
                    $this->selectedFeatures
                );
            })
            ->first();

        $this->stock = $this->variant->stock;
        $this->qty = 1;
    }

    //funcion add_to_cart
    public function add_to_cart()
    {
        Cart::instance('shopping');

        $cartItem = Cart::search(function ($cartItem, $rowId) {
            return $cartItem->options->sku === $this->variant->sku;
        })->first();

        if ($cartItem) {
            $stock = $this->stock - $cartItem->qty;

            if ($stock < $this->qty) {
                $this->dispatch('swal', [
                    'icon' => 'error',
                    'title' => '¡Lo siento!',
                    'text' => 'No hay suficiente stock disponible',
                ]);
                return;
            }
        }



        Cart::add([
            'id'    => $this->product->id,
            'name'  => $this->product->name,
            'qty'   => $this->qty,
            'price' => $this->product->price,
            'options' => [
                'sku'     => $this->variant->sku,      // <-- aquí el cambio clave
                'image'   => $this->product->image,
                'stock'   => $this->variant->stock,
                'features' => Feature::whereIn('id', $this->selectedFeatures)
                    ->pluck('description', 'id')->toArray(),
            ],
            'tax' => 18,
        ])->associate(Product::class);

        if (Auth::check()) {
            Cart::store(Auth::id());
        }

        $this->dispatch('cartUpdated', Cart::count());


        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Producto agregado al carrito de compras',
        ]);
    }



    public function render()
    {
        return view('livewire.products.add-to-cart');
    }
}
