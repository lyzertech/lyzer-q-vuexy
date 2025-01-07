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
        Schema::create('clan_tree', function (Blueprint $table) {
          $table->id('id_tree'); // Primary Key
          $table->string('name'); // Name of the individual
          $table->enum('gender', ['male', 'female']); // Gender of the individual
          $table->unsignedBigInteger('parent_tree_id')->nullable(); // Parent ID
          $table->unsignedBigInteger('spouse_tree_id')->nullable(); // Spouse ID
          $table->timestamps(); // Created at and updated at
          $table->softDeletes(); // Deleted at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clan_tree');
    }
};
