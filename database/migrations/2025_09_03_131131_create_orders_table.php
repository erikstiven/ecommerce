<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('pdf_path')->nullable();

            // $table->longText('content');

            $table->string('address', 255);

            // Solo métodos que usarás: PayPhone (online) y Depósito (manual)
            $table->enum('payment_method', ['payphone', 'deposit'])->default('payphone');

            $table->string('payment_id')->nullable();

            $table->string('client_transaction_id')->nullable()->unique();

            $table->longText('payphone_payload')->nullable();

            $table->string('payphone_transaction_id')->nullable()->unique();

            $table->string('deposit_proof_path')->nullable();

            $table->decimal('total', 12, 2)->default(0.00);

            $table->unsignedBigInteger('amount_cents')->default(0);

            $table->tinyInteger('status')->default(0)->index();

            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
