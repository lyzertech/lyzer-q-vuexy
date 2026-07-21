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
        Schema::create('crm_purchase_request', function (Blueprint $table) {
            $table->id('id_purchase_request');
            $table->string('pr_number')->unique();
            $table->string('customer_name');
            $table->string('customer_po_number');
            $table->string('project_name');
            $table->string('term_of_payment');
            $table->enum('down_payment', ['ON', 'OFF'])->default('OFF');
            $table->date('dp_received_date')->nullable();
            $table->text('item_list');
            $table->integer('quantity');
            $table->decimal('selling_price', 15, 2);
            $table->string('expected_delivery_date')->default('-');
            $table->date('principal_delivery_date')->nullable();
            $table->string('lead_time');
            $table->string('attachment_customer_po')->nullable();
            $table->string('status')->default('PR Created');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_purchase_request');
    }
};
