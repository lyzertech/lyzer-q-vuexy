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
        Schema::create('procurement_comments', function (Blueprint $table) {
            $table->id('id_procurement_comment');
            $table->unsignedBigInteger('id_procurement_request');
            $table->unsignedBigInteger('id_parent_comment')->nullable(); // For threaded comments
            $table->unsignedBigInteger('id_user');
            $table->text('message');
            $table->boolean('is_system')->default(false); // System-generated comments
            $table->timestamp('edited_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['id_procurement_request']);
            $table->index(['id_parent_comment']);
            $table->index(['id_user']);
            $table->index(['is_system']);
            $table->index(['created_at']);
            
            // Foreign Keys
            $table->foreign('id_procurement_request')->references('id_procurement_request')->on('procurement_requests')->onDelete('cascade');
            $table->foreign('id_parent_comment')->references('id_procurement_comment')->on('procurement_comments')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_comments');
    }
};