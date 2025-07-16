<?php

namespace App\Livewire\Products;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Auth; //


class AddToCart extends Component
{

    public $product;

    public $qty = 1;

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
                'image' => (string) $this->product->image,
                'sku' => $this->product->sku,
                'features' => []
            ]
        ]);

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
