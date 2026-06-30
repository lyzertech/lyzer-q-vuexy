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
        Schema::create('procurement_status_histories', function (Blueprint $table) {
            $table->id('id_status_history');
            $table->unsignedBigInteger('id_procurement_request');
            $table->unsignedBigInteger('id_procurement_item')->nullable(); // For item-level status changes
            $table->string('old_status')->nullable();
            $table->string('new_status');
            $table->text('note')->nullable(); // Reason for status change
            $table->unsignedBigInteger('changed_by');
            $table->timestamps();
            
            // Indexes
            $table->index(['id_procurement_request']);
            $table->index(['id_procurement_item']);
            $table->index(['old_status']);
            $table->index(['new_status']);
            $table->index(['changed_by']);
            $table->index(['created_at']);
            
            // Foreign Keys
            $table->foreign('id_procurement_request')->references('id_procurement_request')->on('procurement_requests')->onDelete('cascade');
            $table->foreign('id_procurement_item')->references('id_procurement_item')->on('procurement_items')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_status_histories');
    }
};