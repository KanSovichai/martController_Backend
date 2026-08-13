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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id('purchase_item_id');

            $table->foreignId('purchase_order_id')
                ->constrained('purchase_orders', 'purchase_order_id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained('products', 'product_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            

            $table->integer('qty_ordered');
            $table->integer('qty_received');
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};