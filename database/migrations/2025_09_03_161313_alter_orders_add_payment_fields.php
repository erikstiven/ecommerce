<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Método de pago: 'payphone' | 'deposit'
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method', 20)->nullable()->index();
            }

            // Estado de pago: 'pending' | 'processing' | 'paid' | 'rejected' | 'refunded'
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status', 20)->default('pending')->index();
            }

            // PayPhone tracking
            if (!Schema::hasColumn('orders', 'pp_transaction_id')) {
                $table->string('pp_transaction_id', 100)->nullable()->index();
            }
            if (!Schema::hasColumn('orders', 'pp_client_tx_id')) {
                $table->string('pp_client_tx_id', 120)->nullable()->index();
            }
            if (!Schema::hasColumn('orders', 'pp_raw')) {
                $table->json('pp_raw')->nullable();
            }

            // Depósito: ruta del comprobante y marcas de tiempo de revisión
            if (!Schema::hasColumn('orders', 'deposit_proof_path')) {
                $table->string('deposit_proof_path', 255)->nullable();
            }
            if (!Schema::hasColumn('orders', 'deposited_at')) {
                $table->timestamp('deposited_at')->nullable();
            }
            if (!Schema::hasColumn('orders', 'verified_at')) {
                $table->timestamp('verified_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method','payment_status',
                'pp_transaction_id','pp_client_tx_id','pp_raw',
                'deposit_proof_path','deposited_at','verified_at',
            ]);
        });
    }
};
