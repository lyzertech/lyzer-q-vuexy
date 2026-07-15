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
            $table->string('pr_number')->nullable();
            $table->string('title')->nullable();
            $table->string('requested_by')->nullable();
            $table->string('department')->nullable();
            $table->string('priority')->nullable();
            $table->string('status')->nullable()->default('Pending');
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
