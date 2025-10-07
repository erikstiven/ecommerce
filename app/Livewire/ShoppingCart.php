<?php

namespace App\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

/**
 * Componente Livewire para el carrito de compras.
 *
 * Permite aumentar y disminuir cantidades, eliminar productos o vaciar el carrito,
 * y valida el stock antes de incrementar unidades.
 */
class ShoppingCart extends Component
{
    /**
     * Se ejecuta al montar el componente: establece la instancia del carrito.
     */
    public function mount()
    {
        Cart::instance('shopping');
    }

    /**
     * Incrementa en uno la cantidad de un item, validando que no exceda el stock disponible.
     *
     * @param string $rowId Identificador del item en el carrito
     */
    public function increase($rowId)
    {
        Cart::instance('shopping');

        if (!Cart::content()->has($rowId)) {
            session()->flash('error', 'El producto ya no está en el carrito.');
            return;
        }

        $item      = Cart::get($rowId);
        $available = $item->options->stock ?? null;
        if ($available !== null && ($item->qty + 1) > $available) {
            session()->flash('error', 'No hay suficiente stock para agregar otra unidad.');
            return;
        }

        Cart::update($rowId, $item->qty + 1);

        if (Auth::check()) {
            Cart::store(Auth::id());
        }

        $this->dispatch('cartUpdated', Cart::count());
    }

    /**
     * Calcula el subtotal del carrito considerando solo los items cuya cantidad no excede el stock.
     */
    #[Computed]
    public function subtotal()
    {
        return Cart::content()->filter(function ($item) {
            return $item->qty <= $item->options['stock'];
        })
        ->sum(function ($item) {
            return $item->subtotal;
        });
    }

    /**
     * Disminuye la cantidad de un item o lo elimina si llega a cero.
     *
     * @param string $rowId Identificador del item en el carrito
     */
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

    /**
     * Elimina un item del carrito.
     *
     * @param string $rowId Identificador del item en el carrito
     */
    public function remove($rowId)
    {
        Cart::instance('shopping');
        Cart::remove($rowId);
        if (Auth::check()) {
            Cart::store(Auth::id());
        }
        $this->dispatch('cartUpdated', Cart::count());
    }

    /**
     * Vacía completamente el carrito.
     */
    public function destroy()
    {
        Cart::instance('shopping')->destroy();
        Cart::destroy();

        if (Auth::check()) {
            Cart::store(Auth::id());
        }

        $this->dispatch('cartUpdated', Cart::count());
    }

    /**
     * Renderiza la vista asociada al componente.
     */
    public function render()
    {
        return view('livewire.shopping-cart');
    }
}