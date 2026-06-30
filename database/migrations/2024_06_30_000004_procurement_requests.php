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
        Schema::create('procurement_requests', function (Blueprint $table) {
            $table->id('id_procurement_request');
            $table->string('request_number')->unique();
            $table->unsignedBigInteger('id_user_sales'); // Sales person who created the request
            $table->unsignedBigInteger('id_customer')->nullable(); // Optional customer
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', [
                'draft', 
                'waiting_approval', 
                'approved', 
                'purchasing', 
                'shipping', 
                'partial_arrival', 
                'arrival', 
                'delivered', 
                'completed', 
                'cancelled'
            ])->default('draft');
            $table->date('requested_date');
            $table->date('expected_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            // Workflow approval fields (following your existing pattern)
            $table->text('ack_manager')->nullable();
            $table->text('ack_director')->nullable();
            $table->text('ack_presdir')->nullable();
            
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['request_number']);
            $table->index(['id_user_sales']);
            $table->index(['id_customer']);
            $table->index(['status']);
            $table->index(['priority']);
            $table->index(['requested_date']);
            $table->index(['expected_date']);
            
            // Foreign Keys
            $table->foreign('id_user_sales')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_customer')->references('id_customer')->on('procurement_customers')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_requests');
    }
};