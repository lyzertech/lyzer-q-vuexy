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
        Schema::create('procurement_purchase_orders', function (Blueprint $table) {
            $table->id('id_purchase_order');
            $table->unsignedBigInteger('id_procurement_request');
            $table->unsignedBigInteger('id_supplier');
            $table->string('po_number')->unique();
            $table->date('po_date');
            $table->enum('status', [
                'draft',
                'sent', 
                'acknowledged',
                'partial_received',
                'completed',
                'cancelled'
            ])->default('draft');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            // Indexes
            $table->index(['id_procurement_request']);
            $table->index(['id_supplier']);
            $table->index(['po_number']);
            $table->index(['status']);
            $table->index(['po_date']);
            
            // Foreign Keys
            $table->foreign('id_procurement_request')->references('id_procurement_request')->on('procurement_requests')->onDelete('cascade');
            $table->foreign('id_supplier')->references('id_supplier')->on('procurement_suppliers')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_purchase_orders');
    }
};