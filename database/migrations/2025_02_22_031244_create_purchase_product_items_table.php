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
        Schema::create('purchase_product_items', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->foreignId('product_id')->constrained('products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('product_purchase_id')->constrained('product_purchases')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('price', 8, 2)->default(0);
            $table->integer('qty')->default(0);
            $table->decimal('individual_total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_product_items');
    }
};
