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
            $table->string('brand')->nullable()->after('principal_po_number');
            $table->string('packing_list')->nullable()->after('brand');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crm_purchase_request', function (Blueprint $table) {
            $table->dropColumn(['brand', 'packing_list']);
        });
    }
};
