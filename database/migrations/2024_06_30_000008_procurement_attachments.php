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
        Schema::create('procurement_attachments', function (Blueprint $table) {
            $table->id('id_procurement_attachment');
            $table->unsignedBigInteger('id_procurement_request');
            $table->unsignedBigInteger('id_procurement_comment')->nullable(); // Optional link to comment
            $table->string('file_name'); // Generated file name
            $table->string('original_name'); // Original file name
            $table->string('path'); // File storage path
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable(); // File size in bytes
            $table->unsignedBigInteger('uploaded_by');
            $table->timestamps();
            
            // Indexes
            $table->index(['id_procurement_request']);
            $table->index(['id_procurement_comment']);
            $table->index(['uploaded_by']);
            $table->index(['mime_type']);
            $table->index(['created_at']);
            
            // Foreign Keys
            $table->foreign('id_procurement_request')->references('id_procurement_request')->on('procurement_requests')->onDelete('cascade');
            $table->foreign('id_procurement_comment')->references('id_procurement_comment')->on('procurement_comments')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_attachments');
    }
};