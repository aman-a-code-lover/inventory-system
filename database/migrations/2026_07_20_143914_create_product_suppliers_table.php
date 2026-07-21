<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_suppliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('supplier_sku', 120)->nullable();
            $table->decimal('supplier_cost', 15, 2)->nullable();
            $table->unsignedSmallInteger('lead_time_days')->default(0);
            $table->timestamps();

            $table->unique(['product_id', 'supplier_id', 'supplier_sku']);
            $table->index('product_id');
            $table->index('supplier_id');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_suppliers');
    }
};
