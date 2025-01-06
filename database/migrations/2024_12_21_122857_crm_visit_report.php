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
        Schema::create('crm_visit_report', function (Blueprint $table) {
            $table->id('id_visit_report');
            $table->string('customer_name'); // Name of the customer
            $table->string('sales'); // Name of the sales
            $table->string('location'); // Location of the customer
            $table->string('contact_person'); // Person to meet at the customer site
            $table->string('contact_number'); // Contact number of the person
            $table->date('visit_date'); // Date of the visit
            $table->time('visit_time'); // Time of the visit
            $table->text('purpose'); // Purpose of the visit
            $table->text('notes')->nullable(); // Notes from the visit
            $table->text('customer_feedback')->nullable(); // Feedback from the customer
            $table->string('next_steps')->nullable(); // Next actions after the visit
            $table->date('follow_up_date')->nullable(); // Date for follow-up actions
            $table->string('status')->default('Planned'); // Visit status (e.g., Planned, Completed)
            $table->string('image')->nullable(); // Path to an uploaded image or document
            $table->timestamps(); // Created and updated timestamps
            $table->softDeletes(); // Soft delete column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('crm_visit_report');
    }
};
