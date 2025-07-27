<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout()
    {
        return view('checkout.index'); // Vista principal del checkout
    }

    public function respuesta(Request $request)
    {
        $id = $request->query('id');
        $clientTxId = $request->query('clientTransactionId');

        // ✅ Si los parámetros faltan, redirige al checkout con un mensaje flash
        if (!$id || !$clientTxId) {
            return redirect()
                ->route('checkout.index')
                ->with('error', 'La transacción expiró o ya fue validada.');
        }

        $token = config('services.payphone.token');

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

        $result = json_decode($response, true);

        if (!is_array($result) || !isset($result['transactionStatus'])) {
            return view('checkout.resultado', [
                'error' => 'No se pudo obtener respuesta válida de Payphone.'
            ]);
        }

        return view('checkout.resultado', compact('result'));
    }
}


