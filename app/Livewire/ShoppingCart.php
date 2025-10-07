<?php

namespace App\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart as CartFacade;

class ShoppingCart extends Component
{
    public function mount()
    {
        Cart::instance('shopping');
    }

    public function increase($rowId)
    {
        Cart::instance('shopping');

        if (!Cart::content()->has($rowId)) {
            session()->flash('error', 'El producto ya no está en el carrito.');
            return;
        }

        $item = Cart::get($rowId);
        Cart::update($rowId, $item->qty + 1);

        if (Auth::check()) {
            Cart::store(Auth::id());
        }

        $this->dispatch('cartUpdated', Cart::count());
    }

    #[Computed()]
    public function subtotal(){
        return CartFacade::content()->filter(function($item){
            return $item->qty <= $item->options['stock'];
        })
        ->sum(function($item){
            return $item->subtotal;
        });
    }

    public function decrease($rowId)
    {
        Cart::instance('shopping');

        if (!Cart::content()->has($rowId)) {
            session()->flash('error', 'El producto ya no está en el carrito.');
            return;
        }

        $item = Cart::get($rowId);

        if ($item->qty > 1) {
            Cart::update($rowId, $item->qty - 1);
        } else {
            Cart::remove($rowId);
        }

        if (Auth::check()) {
            Cart::store(Auth::id());
        }

        $this->dispatch('cartUpdated', Cart::count());
    }

    //remove

    public function remove($rowId)
    {
        Cart::instance('shopping');
        Cart::remove($rowId);
        if (Auth::check()) {
            Cart::store(Auth::id());
        }
        $this->dispatch('cartUpdated', Cart::count());
    }

    //detroy
    public function destroy()
    {
        Cart::instance('shopping')->destroy();
        Cart::destroy();

        if (Auth::check()) {
            Cart::store(Auth::id());
        }

        $this->dispatch('cartUpdated', Cart::count());
    }


    public function render()
    {
        return view('livewire.shopping-cart');
    }
}
