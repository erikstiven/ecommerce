<?php

namespace App\Http\Middleware;

use App\Models\Variant;
use Closure;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyStock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cart = Cart::instance('shopping');

        $cartChanged = false;
        foreach ($cart->content() as $item) {
            $options = $item->options ?? [];

            // Intentar obtener el variant por SKU
            $variant = Variant::where('sku', $options['sku'] ?? null)->first();

            if (!$variant) {
                // 🔧 Si no existe, eliminar el producto del carrito
                $cart->remove($item->rowId);
                $cartChanged = true;
                continue; // Pasar al siguiente item
            }

            // Si existe, actualizar el stock actual
            $options['stock'] = $variant->stock;

            $cart->update($item->rowId, [
                'options' => $options,
            ]);
            $cartChanged = true;
        }

        if ($cartChanged && Auth::check()) {
            $cart->store(Auth::id());
        }

        return $next($request);
    }
}
