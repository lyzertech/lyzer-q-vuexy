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
        Schema::create('labs_label', function (Blueprint $table) {
            $table->id('id_label');
            $table->string('brand');
            $table->string('customer');
            $table->string('PO');
            $table->string('type');
            $table->string('qty');
            $table->string('scale');
            $table->string('input');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('labs_label');
    }
};
