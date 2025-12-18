<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Variant;
use Illuminate\Support\Facades\Log;


/**
 * Controlador para el proceso de checkout.
 *
 * Este controlador gestiona la creación de órdenes a partir del carrito, el inicio del pago con PayPhone,
 * la recepción de respuestas de la pasarela y el registro de pagos por depósito.  También valida el
 * stock del carrito antes de proceder a crear la orden y actualiza el inventario una vez aprobado el pago.
 */
class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Verifica que las cantidades del carrito no excedan el stock disponible.
     *
     * @return bool true si todas las cantidades son válidas, false en caso contrario.
     */
    private function validateCartStock(): bool
    {
        Cart::instance('shopping');
        foreach (Cart::content() as $item) {
            // Se intenta tomar el stock del item; si no existe en las opciones, se consulta a la variante por SKU
            $available = $item->options['stock'] ?? null;
            $variantSku = $item->options['sku'] ?? null;

            if ($available === null && $variantSku) {
                $available = Variant::where('sku', $variantSku)->value('stock');
            }

            if ($available !== null && $item->qty > $available) {
                return false;
            }
        }
        return true;
    }

    /**
     * Página principal de checkout.  Valida el stock y devuelve la vista.
     */
    public function checkout()
    {
        Cart::instance('shopping');
        if (!$this->validateCartStock()) {
            return redirect()->route('cart.index')
                ->with('error', 'Algunos productos en tu carrito no tienen suficiente stock.');
        }

        // Obtener contenido del carrito y totales
        $cart     = Cart::instance('shopping');
        $content  = $cart->content();
        $subtotal = (float) preg_replace('/[^\d\.]/', '', (string) $cart->subtotal(2, '.', ''));
        $shipping = 5.00;
        $total    = round($subtotal + $shipping, 2);

        return view('checkout.index', [
            'content'  => $content,
            'subtotal' => $subtotal,
            'delivery' => $shipping,
            'total'    => $total,
        ]);
    }

    /**
     * Crea una orden a partir del contenido del carrito.
     *
     * @param array $extra Información adicional para la orden (método de pago, dirección, etc.)
     */
    private function createOrderFromCart(array $extra = []): Order
    {
        if (!Auth::check()) {
            abort(401, 'Debes iniciar sesión para continuar.');
        }

        return DB::transaction(function () use ($extra) {
            $cart  = Cart::instance('shopping');
            $items = $cart->content();

            if ($items->isEmpty()) {
                abort(400, 'El carrito está vacío.');
            }

            // Se calcula el subtotal limpiando cualquier formato
            $subtotal = (float) preg_replace('/[^\d\.]/', '', (string) $cart->subtotal(2, '.', ''));
            $shipping = 5.00;
            $total    = round($subtotal + $shipping, 2);

            $order = new Order();
            $order->user_id              = Auth::id();
            $order->payment_method       = $extra['payment_method'] ?? null;
            $order->payment_status       = $extra['payment_status'] ?? 'pending';
            // Por defecto la orden queda pendiente hasta que se apruebe el pago
            $order->status               = OrderStatus::Pendiente;

            $order->subtotal             = $subtotal;
            $order->shipping_cost        = $shipping;
            $order->total                = $total;
            $order->subtotal_cents       = (int) round($subtotal * 100);
            $order->shipping_cost_cents  = (int) round($shipping * 100);
            $order->total_cents          = (int) round($total * 100);

            $order->address              = $extra['address'] ?? [];
            $order->content              = $items->toArray();
            $order->pp_client_tx_id      = $extra['pp_client_tx_id'] ?? null;
            $order->deposited_at         = $extra['deposited_at'] ?? null;

            $order->save();

            foreach ($items as $row) {
                $order->items()->create([
                    'product_id'      => $row->id,
                    'product_title'   => $row->name,
                    'sku'             => $row->options->sku ?? null,
                    'unit_price'      => (float) $row->price,
                    'qty'             => (int) $row->qty,
                    'line_total'      => round(((float) $row->price) * (int) $row->qty, 2),
                    'tax_amount'      => 0,
                    'discount_amount' => 0,
                ]);
            }

            return $order;
        });
    }

    /**
     * Inicia el pago mediante PayPhone.  Valida el stock, genera la orden y devuelve
     * los parámetros necesarios para inicializar la pasarela.
     */
    public function startPayphone(Request $request)
    {
        if (!$this->validateCartStock()) {
            return redirect()->route('cart.index')
                ->with('error', 'Algunos productos en tu carrito no tienen suficiente stock.');
        }

        // Generar identificador único para la transacción
        $clientTxId = 'ORD-' . Str::padLeft((string)(now()->timestamp % 1000000), 6, '0') . '-' . Str::uuid();

        // Obtener la dirección por defecto del usuario
        $defaultAddress = Address::where('user_id', Auth::id())
            ->where('default', true)
            ->first();
        $addressData = $defaultAddress ? $defaultAddress->toArray() : null;

        // Crear la orden con estado pendiente
        $order = $this->createOrderFromCart([
            'payment_method'  => 2,
            'payment_status'  => 'pending',
            'pp_client_tx_id' => $clientTxId,
            'address'         => $addressData,
        ]);

        // Obtener contenido del carrito y totales
        $cart     = Cart::instance('shopping');
        $content  = $cart->content();
        $subtotal = (float) preg_replace('/[^\d\.]/', '', (string) $cart->subtotal(2, '.', ''));
        $shipping = 5.00;
        $total    = round($subtotal + $shipping, 2);

        $ppParams = [
            'token'               => config('services.payphone.token'),
            'storeId'             => config('services.payphone.store_id'),
            'clientTransactionId' => $clientTxId,
            'amount'              => $order->total_cents,
            'amountWithTax'       => 0,
            'amountWithoutTax'    => $order->subtotal_cents,
            'tax'                 => 0,
            'service'             => $order->shipping_cost_cents,
            'tip'                 => 0,
        ];

        return view('checkout.index', [
            'order'    => $order,
            'pp'       => $ppParams,
            'content'  => $content,
            'subtotal' => $subtotal,
            'delivery' => $shipping,
            'total'    => $total,
        ]);
    }



    /**
     * Procesa la respuesta de PayPhone.  Actualiza la orden y el stock en función del
     * estado de la transacción y redirige a la pantalla final.
     */
    public function respuesta(Request $request)
    {
        $id         = $request->query('id');
        $clientTxId = $request->query('clientTransactionId');

        if (!$id || !$clientTxId) {
            return redirect()->route('checkout.index')
                ->with('error', 'Transacción inválida.');
        }

        $token    = config('services.payphone.token');
        $response = $this->confirmarTransaccion($id, $clientTxId, $token);
        $result   = json_decode($response, true);

        if (!is_array($result) || !isset($result['transactionStatus'])) {
            return redirect()->route('checkout.index')
                ->with('error', 'Respuesta inválida de PayPhone.');
        }

        // Verificar si la orden existe
        $order = Order::where('pp_client_tx_id', $clientTxId)->first();

        if ($order) {
            // Guardar detalles de la transacción
            $order->pp_transaction_id = $result['transactionId'] ?? null;
            $order->pp_authorization_code = $result['authorizationCode'] ?? null;
            $order->pp_card_brand = $result['cardBrand'] ?? null;
            $order->pp_last_digits = $result['cardLastDigits'] ?? null;

            if ($result['transactionStatus'] === 'Approved') {
                // Si la transacción fue aprobada, cambiar el estado
                $order->payment_status = 'paid';
                $order->status         = OrderStatus::Completado;
                $order->save();

                // Descontar stock de los productos del pedido
                foreach ($order->items as $item) {
                    if ($item->sku) {
                        Variant::where('sku', $item->sku)->decrement('stock', $item->qty);
                    }
                }

                Cart::instance('shopping')->destroy();
                session()->flash('order_id', $order->id);
                session()->flash('pago_estado', 'Approved');

                return redirect()->route('checkout.paid');
            } else {
                // Si no se aprobó, marcar como rechazado
                $order->payment_status = 'rejected';
                $order->status         = OrderStatus::Fallido;
                $order->save();

                session()->flash('pago_estado', 'Rejected');

                return redirect()->route('checkout.paid');
            }
        }

        session()->flash('pago_estado', 'Invalid');
        return redirect()->route('checkout.paid');
    }


    /**
     * Registra un pago por depósito bancario.  Crea la orden y almacena el comprobante.
     */
    public function deposit(Request $request)
    {
        $rules = [
            'deposit_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
        $messages = [
            'deposit_proof.required' => 'Debes subir el comprobante de depósito.',
            'deposit_proof.file'     => 'El comprobante debe ser un archivo válido.',
            'deposit_proof.mimes'    => 'El comprobante debe ser JPG, JPEG, PNG o PDF.',
            'deposit_proof.max'      => 'El comprobante no debe superar los 5 MB.',
        ];
        $attributes = [
            'deposit_proof' => 'comprobante de depósito',
        ];

        $validated = $request->validate($rules, $messages, $attributes);

        // Dirección por defecto (igual que antes)
        $defaultAddress = Address::where('user_id', Auth::id())
            ->where('default', true)
            ->first();
        $addressData = $defaultAddress ? $defaultAddress->toArray() : null;

        $order = $this->createOrderFromCart([
            'payment_method' => 1,
            'payment_status' => 'processing',
            'deposited_at'   => now(),
            'address'        => $addressData,
        ]);

        // Reservar stock para cada producto
        foreach ($order->items as $item) {
            if ($item->sku) {
                Variant::where('sku', $item->sku)->decrement('stock', $item->qty);
            }
        }

        session()->flash('order_id', $order->id);
        session()->flash('pago_estado', 'Processing');

        // Guardar comprobante de depósito en disco 'public'
        $path = $request->file('deposit_proof')->store("deposits/{$order->id}", 'public');
        $order->update(['deposit_proof_path' => $path]);

        Cart::instance('shopping')->destroy();

        return redirect()->route('checkout.thanks')
            ->with('success', 'Comprobante recibido. Tu pago será verificado.');
    }

    /**
     * Muestra la página de agradecimiento tras el pago.  Si la sesión contiene una orden, la devuelve a la vista.
     */
    public function paid()
    {
        $order = null;
        if (session('order_id')) {
            $order = Order::find(session('order_id'));
        }
        return view('checkout.thanks', compact('order'));
    }

    public function thanks()
    {
        return view('checkout.thanks');
    }

    /**
     * Confirma la transacción con la API de PayPhone.
     */
    private function confirmarTransaccion($id, $clientTxId, $token)
    {
        $headers = [
            "Authorization: bearer $token",
            "Content-Type: application/json",
        ];

        $body = json_encode([
            'id'         => (int) $id,        // Payphone espera un número
            'clientTxId' => $clientTxId,
        ]);

        $curl = curl_init();
        // Endpoint oficial para sandbox y producción
        curl_setopt($curl, CURLOPT_URL, "https://pay.payphonetodoesposible.com/api/button/V2/Confirm");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
