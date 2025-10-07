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

    public $qty = 1;

    public $selectedFeatures = [];




    //mount
    public function mount()
    {

        $this->selectedFeatures = $this->product->variants->first()->features->pluck('id', 'option_id')->toArray();
    }

    //public variant
    #[Computed]
    public function variant()
    {
        if (!$this->product?->variants || empty($this->selectedFeatures)) {
            return null;
        }

        return $this->product->variants
            ->filter(function ($variant) {
                return !array_diff(
                    $variant->features()->pluck('features.id')->toArray(),
                    $this->selectedFeatures
                );
            })
            ->first();
    }

    //funcion add_to_cart
    public function add_to_cart()
    {
        Cart::instance('shopping');

        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->qty,
            'price' => $this->product->price,
            'options' => [
                'image' => $this->product->image,
                'code' => $this->variant->sku,
                'features' => Feature::whereIn('id', $this->selectedFeatures)
                    ->pluck('description', 'id')->toArray()
            ],
            'tax' => 18,
        ])
        ->associate(Product::class);

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
