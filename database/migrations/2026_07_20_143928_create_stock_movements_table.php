<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->enum('movement_type', ['purchase','sale','purchase_return','sale_return','adjustment','transfer_in','transfer_out','manual']);
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->unsignedBigInteger('purchase_return_id')->nullable();
            $table->unsignedBigInteger('sale_return_id')->nullable();
            $table->unsignedBigInteger('stock_adjustment_id')->nullable();
            $table->decimal('quantity', 14, 4)->default(0);
            $table->decimal('unit_cost', 15, 2)->nullable();
            $table->decimal('balance_after', 14, 4)->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->index(['product_id']);
            $table->index(['product_id', 'warehouse_id']);
            $table->index('movement_type');
            $table->index('created_at');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('set null');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('set null');
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('set null');
            $table->foreign('purchase_return_id')->references('id')->on('purchase_returns')->onDelete('set null');
            $table->foreign('sale_return_id')->references('id')->on('sale_returns')->onDelete('set null');
            $table->foreign('stock_adjustment_id')->references('id')->on('stock_adjustments')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
