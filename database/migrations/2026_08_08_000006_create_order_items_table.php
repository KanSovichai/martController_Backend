<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_item_id');

            $table->foreignId('order_id')
                ->constrained('sale_orders', 'order_id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained('products', 'product_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer('quantity_sold');
            $table->decimal('unit_price_sale', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};