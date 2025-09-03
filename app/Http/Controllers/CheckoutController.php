<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Str;
use App\Enums\OrderStatus;   // <= agrega esto


class CheckoutController extends Controller
{
    /**
     * Muestra la vista de checkout.
     */
    public function checkout()
    {
        return view('checkout.index');
    }

    /**
     * Crear orden desde el carrito (transaccional).
     */
    private function createOrderFromCart(array $extra = []): Order
    {
        if (!Auth::check()) {
            abort(401, 'Debes iniciar sesión para continuar.');
        }

        return DB::transaction(function () use ($extra) {
            $cart = Cart::instance('shopping');
            $items = $cart->content();

            if ($items->isEmpty()) {
                abort(400, 'El carrito está vacío.');
            }

            // Calcula montos como float
            $subtotalStr = (string) ($cart->subtotal(2, '.', '') ?? '0');
            $subtotal = (float) preg_replace('/[^\d\.]/', '', $subtotalStr);
            $shipping = 5.00;
            $total = round($subtotal + $shipping, 2);

            $order = new Order();
            $order->user_id = Auth::id();
            $order->payment_method = $extra['payment_method'] ?? null;
            $order->payment_status = $extra['payment_status'] ?? 'pending';

            if (Schema::hasColumn('orders', 'status'))         $order->status = OrderStatus::Pending;

            if (Schema::hasColumn('orders', 'subtotal'))       $order->subtotal = $subtotal;
            if (Schema::hasColumn('orders', 'shipping_cost'))  $order->shipping_cost = $shipping;
            if (Schema::hasColumn('orders', 'total'))          $order->total = $total;

            if (Schema::hasColumn('orders', 'contact') && !isset($extra['contact'])) {
                $order->contact = [];
            }
            if (Schema::hasColumn('orders', 'address') && !isset($extra['address'])) {
                $order->address = [];
            }

            if (isset($extra['pp_client_tx_id']) && Schema::hasColumn('orders', 'pp_client_tx_id')) {
                $order->pp_client_tx_id = $extra['pp_client_tx_id'];
            }

            if (isset($extra['deposited_at']) && Schema::hasColumn('orders', 'deposited_at')) {
                $order->deposited_at = $extra['deposited_at'];
            }

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
     * Inicia el proceso de pago con PayPhone (ORD-000000-UUID).
     */
    public function startPayphone(Request $request)
    {
        // Genera clientTxId antes de crear la orden
        $clientTxId = 'ORD-' . Str::padLeft((string)(now()->timestamp % 1000000), 6, '0') . '-' . Str::uuid();

        // Crea la orden con PayPhone
        $order = $this->createOrderFromCart([
            'payment_method'  => 'payphone',
            'payment_status'  => 'pending',
            'pp_client_tx_id' => $clientTxId,
        ]);

        // Montos a centavos
        $amount = (int) round(($order->total ?? 0) * 100);
        $amountWithTax = (int) round(($order->subtotal ?? 0) * 100);

        return view('checkout.index', [
            'order' => $order,
            'pp' => [
                'token'               => config('services.payphone.token'),
                'storeId'             => config('services.payphone.store_id'),
                'clientTransactionId' => $clientTxId,
                'amount'              => $amount,
                'amountWithTax'       => $amountWithTax,
                'tax'                 => 500, // fijo o dinámico
            ],
        ]);
    }

    /**
     * Procesa la respuesta desde PayPhone (Confirm).
     */
    public function respuesta(Request $request)
    {
        $id = $request->query('id');
        $clientTxId = $request->query('clientTransactionId');

        if (!$id || !$clientTxId) {
            return redirect()->route('checkout.index')
                ->with('error', 'La transacción expiró o ya fue validada.');
        }

        $token = config('services.payphone.token');
        $response = $this->confirmarTransaccion($id, $clientTxId, $token);
        $result = json_decode($response, true);

        if (!is_array($result) || !isset($result['transactionStatus'])) {
            return redirect()->route('checkout.index')
                ->with('error', 'No se pudo obtener respuesta válida de PayPhone.');
        }

        $order = Order::where('pp_client_tx_id', $clientTxId)->first();

        if ($order) {
            $order->pp_transaction_id = $result['id'] ?? null;
            $order->pp_raw = $result; // <— array, no json_encode

            if (($result['transactionStatus'] ?? null) === 'Approved') {
                $order->payment_status = 'paid';
                $order->status = OrderStatus::Completed;
                $order->save();

                Cart::instance('shopping')->destroy();
                session()->flash('pago_estado', $result['transactionStatus']);
                session()->flash('pago_detalle', $result);

                return redirect()->route('checkout.paid');
            }

            // Rechazada o cancelada
            $order->payment_status = 'rejected';
            $order->status = OrderStatus::Failed; // o OrderStatus::Cancelled si prefieres mapear cancelaciones
            $order->save();
        }


        session()->flash('pago_estado', $result['transactionStatus']);
        session()->flash('pago_detalle', $result);

        if ($result['transactionStatus'] === 'Approved') {
            return redirect()->route('checkout.paid');
        }

        return redirect()->route('checkout.index')
            ->with('error', 'La transacción fue rechazada o cancelada.');
    }

    /**
     * Pago por depósito (con comprobante).
     */
    public function deposit(Request $request)
    {
        $validated = $request->validate([
            'deposit_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ], [
            'deposit_proof.required' => 'Adjunta el comprobante.',
            'deposit_proof.mimes'    => 'Formato inválido (JPG, PNG o PDF).',
            'deposit_proof.max'      => 'Máximo 5MB.',
        ]);

        $order = $this->createOrderFromCart([
            'payment_method' => 'deposit',
            'payment_status' => 'processing',
            'deposited_at'   => now(),
        ]);

        $path = $request->file('deposit_proof')->store("deposits/{$order->id}", 'public');

        $order->update([
            'deposit_proof_path' => $path,
        ]);

        Cart::instance('shopping')->destroy();

        return redirect()->route('checkout.thanks')
            ->with('success', 'Comprobante recibido. Tu pago será verificado.');
    }

    /**
     * Vista para pagos exitosos.
     */
    public function paid()
    {
        return view('checkout.thanks')
            ->with('success', '¡Pago realizado con éxito!');
    }

    /**
     * Vista final luego de pago o depósito.
     */
    public function thanks()
    {
        return view('checkout.thanks');
    }

    /**
     * Confirmar transacción con API de PayPhone.
     */
    private function confirmarTransaccion($id, $clientTxId, $token)
    {
        $headers = [
            "Authorization: Bearer $token",
            "Content-Type: application/json"
        ];

        $body = json_encode([
            'id' => (int) $id,
            'clientTxId' => $clientTxId
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
