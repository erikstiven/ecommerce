<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Resultado del Pago</h2>

        @isset($error)
            <div class="text-red-600 font-semibold">{{ $error }}</div>
        @else
            @if ($result['statusCode'] == 3)
                <div class="text-green-600 font-semibold">✅ ¡Pago Aprobado!</div>
                <p>Transacción ID: {{ $result['transactionId'] }}</p>
                <p>Autorización: {{ $result['authorizationCode'] }}</p>
                <p>Monto: ${{ number_format($result['amount'] / 100, 2) }}</p>
                <p>Tarjeta: {{ $result['cardBrand'] }}</p>
            @else
                <div class="text-red-600 font-semibold">❌ Pago Cancelado</div>
                <p>Mensaje: {{ $result['message'] ?? 'Sin mensaje' }}</p>
            @endif
        @endisset

        <a href="{{ url('/') }}">Volver al inicio</a>
    </div>
</x-app-layout>
