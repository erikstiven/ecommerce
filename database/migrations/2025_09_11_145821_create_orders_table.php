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

            // Usuario
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->index();

            // Documento y datos de la orden
            $table->string('pdf_path')->nullable();
            $table->json('content');                // items del carrito
            $table->json('address')->nullable();    // dirección/envío

            // Pago (curso)
            $table->tinyInteger('payment_method');  // 1=depósito, 2=PayPhone (ej.)
            $table->string('payment_id', 100)->nullable();

            // Montos en USD
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            // Montos en centavos (PayPhone usa enteros)
            $table->unsignedBigInteger('subtotal_cents')->nullable();
            $table->unsignedBigInteger('shipping_cost_cents')->nullable();
            $table->unsignedBigInteger('total_cents')->nullable();

            // Estados
            $table->tinyInteger('status')->default(1);           // Enum OrderStatus
            $table->string('payment_status')->default('pending'); // pending|paid|rejected

            // PayPhone
            $table->string('pp_client_tx_id', 100)->nullable()->unique(); // clientTransactionId
            $table->string('pp_transaction_id', 100)->nullable();
            $table->json('pp_raw')->nullable();                   // respuesta completa

            // Conciliación rápida
            $table->string('pp_authorization_code', 100)->nullable();
            $table->string('pp_card_brand', 20)->nullable();
            $table->string('pp_last_digits', 4)->nullable();

            // Moneda
            $table->string('currency', 3)->nullable()->default('USD');

            // Depósitos
            $table->timestamp('deposited_at')->nullable();
            $table->string('deposit_proof_path')->nullable();

            $table->timestamps();

            // Índices
            $table->index('pp_transaction_id', 'orders_pp_transaction_id_index');
            $table->index('status', 'orders_status_index');
            $table->index('payment_status', 'orders_payment_status_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
