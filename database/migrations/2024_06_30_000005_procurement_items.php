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
        Schema::create('procurement_items', function (Blueprint $table) {
            $table->id('id_procurement_item');
            $table->unsignedBigInteger('id_procurement_request');
            $table->unsignedBigInteger('id_product')->nullable(); // Optional link to product master
            $table->string('product_name');
            $table->text('specification')->nullable();
            $table->decimal('requested_qty', 10, 2);
            $table->decimal('arrived_qty', 10, 2)->default(0);
            $table->decimal('delivered_qty', 10, 2)->default(0);
            $table->decimal('remaining_qty', 10, 2)->storedAs('requested_qty - arrived_qty'); // Computed column
            $table->string('unit'); // pcs, kg, meter, etc.
            $table->enum('status', [
                'requested',
                'ordered', 
                'production',
                'shipping',
                'partial_arrival',
                'arrival',
                'delivered',
                'cancelled'
            ])->default('requested');
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['id_procurement_request']);
            $table->index(['id_product']);
            $table->index(['status']);
            $table->index(['product_name']);
            
            // Foreign Keys
            $table->foreign('id_procurement_request')->references('id_procurement_request')->on('procurement_requests')->onDelete('cascade');
            $table->foreign('id_product')->references('id_product')->on('procurement_products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_items');
    }
};