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

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('pdf_path')->nullable();

            // Si tu MySQL soporta JSON (>=5.7) usa json(); si no, cambia a longText() antes de ejecutar.
            $table->json('content');

            $table->string('address', 255);

            $table->enum('payment_method', ['card', 'deposit', 'payphone'])->default('card');

            $table->string('payment_id')->nullable();

            $table->string('client_transaction_id')->nullable()->unique();

            $table->json('payphone_payload')->nullable();

            $table->string('payphone_transaction_id')->nullable()->unique();

            $table->string('deposit_proof_path')->nullable();

            $table->decimal('total', 10, 2)->default(0);

            $table->integer('amount_cents')->default(0);

            $table->tinyInteger('status')->default(0)->index(); // 0 = pending

            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
