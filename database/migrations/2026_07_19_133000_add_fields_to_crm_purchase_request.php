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
        Schema::table('crm_purchase_request', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('pr_number');
            $table->string('customer_po_number')->nullable()->after('customer_name');
            $table->string('project_name')->nullable()->after('customer_po_number');
            $table->text('item_list')->nullable()->after('project_name');
            $table->integer('quantity')->nullable()->after('item_list');
            $table->decimal('selling_price', 15, 2)->nullable()->after('quantity');
            $table->decimal('supplier_price', 15, 2)->nullable()->after('selling_price');
            $table->date('expected_delivery_date')->nullable()->after('supplier_price');
            $table->string('lead_time')->nullable()->after('expected_delivery_date');
            $table->string('attachment_customer_po')->nullable()->after('lead_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crm_purchase_request', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'customer_po_number',
                'project_name',
                'item_list',
                'quantity',
                'selling_price',
                'supplier_price',
                'expected_delivery_date',
                'lead_time',
                'attachment_customer_po',
            ]);
        });
    }
};
