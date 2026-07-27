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

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('supplier_id')
                ->constrained('suppliers')
                ->cascadeOnDelete();

            // Supplier specific information
            $table->string('supplier_sku', 120)
                ->nullable();

            $table->decimal('supplier_cost', 15, 2)
                ->nullable();

            $table->unsignedSmallInteger('lead_time_days')
                ->default(0);

            // Optional supplier preference
            $table->boolean('is_primary')
                ->default(false);

            $table->timestamps();


            /*
             |--------------------------------------------------------------------------
             | Indexes
             |--------------------------------------------------------------------------
             */

            // Prevent duplicate product-supplier combination
            $table->unique(
                ['product_id', 'supplier_id'],
                'product_supplier_unique'
            );

            // Faster supplier/product searching
            $table->index('product_id');
            $table->index('supplier_id');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('product_suppliers');
    }
};
