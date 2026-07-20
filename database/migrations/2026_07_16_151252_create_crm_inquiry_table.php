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
        Schema::create('crm_inquiry', function (Blueprint $table) {
            $table->id('id_inquiry');
            $table->string('inquiry_number')->unique();
            $table->string('title'); // Project name
            $table->string('pic_sales');
            $table->string('product_type');
            $table->string('priority'); // Low, Medium, High, Urgent
            $table->string('status')->default('Waiting Supplier Feedback');
            
            // Fields filled by Purchasing
            $table->text('price_information')->nullable();
            $table->string('lead_time')->nullable();
            $table->string('moq')->nullable();
            $table->string('availability_status')->nullable();
            $table->string('shipping_terms')->nullable();
            $table->string('validity_period')->nullable();
            
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_inquiry');
    }
};
