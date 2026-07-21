<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no', 120)->unique();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->text('reason')->nullable();
            $table->decimal('total_adjusted', 14, 4)->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('status', ['pending', 'posted', 'cancelled'])->default('pending');
            $table->timestamps();
            $table->softDeletes();

            $table->index('warehouse_id');
            $table->index('status');

            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_adjustments');
    }
};
