<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('engineering_wikis', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('customer_name')->nullable();
            $table->enum('category', ['issue', 'update', 'note']);
            $table->string('brand');
            $table->string('device_type');
            $table->string('model');
            $table->string('serial_number')->nullable();
            $table->string('firmware_version')->nullable();
            $table->string('hardware_version')->nullable();
            $table->text('symptom')->nullable();
            $table->text('root_cause')->nullable();
            $table->text('solution')->nullable();
            $table->text('action_taken')->nullable();
            $table->enum('status', ['open', 'monitoring', 'solved', 'closed']);
            $table->enum('priority', ['low', 'medium', 'high', 'critical']);
            $table->string('reference_doc')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('engineering_wikis');
    }
};
