<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_adjustment_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_adjustment_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('quantity_before', 14, 4)->default(0);
            $table->decimal('quantity_after', 14, 4)->default(0);
            $table->decimal('adjustment_quantity', 14, 4)->default(0);
            $table->text('reason')->nullable();
            $table->timestamps();

            $table->index('stock_adjustment_id');
            $table->index('product_id');

            $table->foreign('stock_adjustment_id')->references('id')->on('stock_adjustments')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_adjustment_items');
    }
};
