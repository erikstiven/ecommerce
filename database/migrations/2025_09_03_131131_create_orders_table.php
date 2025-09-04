
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relación con usuario
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Ruta del PDF generado
            $table->string('pdf_path')->nullable();

            // Contenido del carrito o productos en formato JSON
            $table->json('content');

            // Dirección del envío
            $table->string('address');

            // Método de pago (enum: efectivo o transferencia)
            $table->enum('payment_method', ['card', 'deposit']);

            // ID de transacción externa (opcional)
            $table->string('payment_id');//numero de la transaccion

            // Total de la compra
            $table->decimal('total', 10, 2);

            // Estado de la orden
            $table->tinyInteger('status')->default(1); // 0: pendiente, 1: pagado, 2: cancelado

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
