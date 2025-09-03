<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // FK a orders (cascade delete)
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');

            // FK a products (restrict delete)
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');

            $table->string('product_title', 255);
            $table->string('sku', 100)->nullable();

            $table->decimal('unit_price', 10, 2);
            $table->unsignedInteger('qty');
            $table->decimal('line_total', 10, 2);

            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();

            $table->timestamps();

            $table->index('order_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
