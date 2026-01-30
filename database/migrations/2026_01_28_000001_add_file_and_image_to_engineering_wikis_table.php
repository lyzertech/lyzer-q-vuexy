<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('engineering_wikis', function (Blueprint $table) {
            $table->string('symptom_file')->nullable();
            $table->string('symptom_image')->nullable();
            $table->string('root_cause_file')->nullable();
            $table->string('root_cause_image')->nullable();
            $table->string('solution_file')->nullable();
            $table->string('solution_image')->nullable();
            $table->string('action_taken_file')->nullable();
            $table->string('action_taken_image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('engineering_wikis', function (Blueprint $table) {
            $table->dropColumn([
                'symptom_file', 'symptom_image',
                'root_cause_file', 'root_cause_image',
                'solution_file', 'solution_image',
                'action_taken_file', 'action_taken_image',
            ]);
        });
    }
};
