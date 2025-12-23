<?php

namespace App\Http\Middleware;

use App\Models\Variant;
use Closure;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        foreach ($cart->content() as $item) {
            $options = is_array($item->options ?? null)
                ? $item->options
                : (array) ($item->options?->toArray() ?? []);

            // Intentar obtener el variant por SKU
            $variant = Variant::where('sku', $options['sku'] ?? null)->first();

            if (!$variant) {
                // 🔧 Si no existe, eliminar el producto del carrito
                $cart->remove($item->rowId);
                continue; // Pasar al siguiente item
            }

            // Si existe, actualizar el stock actual
            $options['stock'] = $variant->stock;

            $cart->update($item->rowId, [
                'options' => $options,
            ]);
        }

        if (Auth::check()) {
            $cart->store(Auth::id());
        }

        return $next($request);
    }
}
