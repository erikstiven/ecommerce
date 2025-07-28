<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * Procesa la respuesta de PayPhone tras el pago.
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
                ->with('error', 'No se pudo obtener respuesta válida de Payphone.');
        }

        // Flash info para mostrar en la vista "thanks"
        session()->flash('pago_estado', $result['transactionStatus']);
        session()->flash('pago_detalle', $result);

        // Redirección según estado del pago
        if ($result['transactionStatus'] === 'Approved') {
            return redirect()->route('checkout.paid');
        }

        return redirect()->route('checkout.index')
            ->with('error', 'La transacción fue rechazada o cancelada.');
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
     * Vista final, se puede mostrar siempre.
     */
    public function thanks()
    {
        return view('checkout.thanks');
    }

    /**
     * Lógica para confirmar el estado del pago desde PayPhone.
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
