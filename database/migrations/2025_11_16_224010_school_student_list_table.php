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
        Schema::create('school_students', function (Blueprint $table) {
            $table->id();

            // Unique student identifier (NIS)
            $table->string('nis')->unique();

            // Basic info
            $table->string('name');
            $table->enum('gender', ['Male', 'Female']);

            // Class (1–6)
            $table->unsignedTinyInteger('class'); // value 1-6

            // Birth info
            $table->date('birthdate')->nullable();

            // Guardian information
            $table->string('parent_name')->nullable();
            $table->string('contact_number')->nullable();

            // Address
            $table->text('address')->nullable();

            // Active / Transferred / Graduated
            $table->enum('status', ['Active', 'Transferred', 'Graduated'])->default('Active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_students');
    }
};
