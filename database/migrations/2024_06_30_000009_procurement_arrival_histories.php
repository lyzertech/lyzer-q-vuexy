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
        Schema::create('procurement_arrival_histories', function (Blueprint $table) {
            $table->id('id_arrival_history');
            $table->unsignedBigInteger('id_procurement_item');
            $table->decimal('qty', 10, 2); // Quantity that arrived in this batch
            $table->date('arrival_date');
            $table->string('warehouse')->nullable(); // Warehouse where items arrived
            $table->text('note')->nullable(); // Notes about this arrival
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            // Indexes
            $table->index(['id_procurement_item']);
            $table->index(['arrival_date']);
            $table->index(['created_by']);
            $table->index(['created_at']);
            
            // Foreign Keys
            $table->foreign('id_procurement_item')->references('id_procurement_item')->on('procurement_items')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_arrival_histories');
    }
};