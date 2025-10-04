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

class CheckoutController extends Controller
{
    public function checkout()
    {
        return view('checkout.index');
    }

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

            $subtotal = (float) preg_replace('/[^\d\.]/', '', (string) $cart->subtotal(2, '.', ''));
            $shipping = 5.00;
            $total    = round($subtotal + $shipping, 2);

            $order = new Order();
            $order->user_id              = Auth::id();
            $order->payment_method       = $extra['payment_method'] ?? null;
            $order->payment_status       = $extra['payment_status'] ?? 'pending';
            $order->status               = OrderStatus::Pendiente; // Estado pendiente para pagos no completados

            $order->subtotal             = $subtotal;
            $order->shipping_cost        = $shipping;
            $order->total                = $total;
            $order->subtotal_cents       = (int) round($subtotal * 100);
            $order->shipping_cost_cents  = (int) round($shipping * 100);
            $order->total_cents          = (int) round($total * 100);

            $order->address              = $extra['address'] ?? [];
            $order->content              = $items->toArray(); // snapshot del carrito
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

    public function startPayphone(Request $request)
    {
        $clientTxId = 'ORD-' . Str::padLeft((string)(now()->timestamp % 1000000), 6, '0') . '-' . Str::uuid();

        // Obtener la dirección por defecto del usuario
        $defaultAddress = Address::where('user_id', Auth::id())
            ->where('default', true)
            ->first();
        $addressData = $defaultAddress ? $defaultAddress->toArray() : null;

        $order = $this->createOrderFromCart([
            'payment_method'  => 2,
            'payment_status'  => 'pending',
            'pp_client_tx_id' => $clientTxId,
            'address'         => $addressData,
        ]);

        $subtotal = $order->subtotal_cents;
        $shipping = $order->shipping_cost_cents;
        $amount   = $order->total_cents;

        $ppParams = [
            'token'               => config('services.payphone.token'),
            'storeId'             => config('services.payphone.store_id'),
            'clientTransactionId' => $clientTxId,
            'amount'              => $amount,
            'amountWithTax'       => 0,
            'amountWithoutTax'    => $subtotal,
            'tax'                 => 0,
            'service'             => $shipping,
            'tip'                 => 0,
        ];

        return view('checkout.index', [
            'order' => $order,
            'pp'    => $ppParams,
        ]);
    }

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

        $order = Order::where('pp_client_tx_id', $clientTxId)->first();

        if ($order) {
            // IDs / códigos
            $order->pp_transaction_id     = $result['transactionId']
                                          ?? $result['payphoneTransactionId']
                                          ?? $result['id']
                                          ?? null;

            $order->pp_authorization_code = $result['authorizationCode'] ?? null;

            // Marca y últimos 4
            $order->pp_card_brand         = $result['cardBrand']
                                          ?? ($result['card']['brand'] ?? null);

            $order->pp_last_digits        = $result['cardLastDigits']
                                          ?? ($result['card']['lastDigits'] ?? null)
                                          ?? (isset($result['cardNumber']) ? substr(preg_replace('/\D/', '', $result['cardNumber']), -4) : null)
                                          ?? (isset($result['maskedCard']) ? substr(preg_replace('/\D/', '', $result['maskedCard']), -4) : null);

            // Raw completo
            $order->pp_raw                = $result;

            if ($result['transactionStatus'] === 'Approved') {
                $order->payment_status = 'paid';
                $order->status = OrderStatus::Completado;
                $order->save();

                // Almacenar en sesión el ID de la orden y el estado
                session()->flash('order_id', $order->id);
                session()->flash('pago_estado', 'Approved');

                Cart::instance('shopping')->destroy();
                return redirect()->route('checkout.paid');
            }

            $order->payment_status = 'rejected';
            $order->status = OrderStatus::Fallido;
            $order->save();

            // Almacenar estado de rechazo para la vista
            session()->flash('pago_estado', 'Rejected');

            return redirect()->route('checkout.paid');
        }

        // Si no se encuentra la orden, redirige con error
        session()->flash('pago_estado', 'Invalid');
        return redirect()->route('checkout.paid');
    }

    public function deposit(Request $request)
    {
        $validated = $request->validate([
            'deposit_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        // Obtener la dirección por defecto del usuario
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

        // Guardar en sesión el id de la orden y estado (por si quieres mostrar resumen)
        session()->flash('order_id', $order->id);
        session()->flash('pago_estado', 'Processing');

        $path = $request->file('deposit_proof')->store("deposits/{$order->id}", 'public');
        $order->update(['deposit_proof_path' => $path]);

        Cart::instance('shopping')->destroy();

        return redirect()->route('checkout.thanks')
            ->with('success', 'Comprobante recibido. Tu pago será verificado.');
    }

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

    private function confirmarTransaccion($id, $clientTxId, $token)
    {
        $headers = [
            "Authorization: Bearer $token",
            "Content-Type: application/json",
        ];

        $body = json_encode([
            'id'         => (int) $id,
            'clientTxId' => $clientTxId,
        ]);

        $curl = curl_init();
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
