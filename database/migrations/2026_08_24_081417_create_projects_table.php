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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('project_type')->default('Laravel Web App');
            $table->string('client_name');
            $table->string('client_phone')->nullable();
            $table->string('client_email')->nullable();
            $table->string('project_manager')->nullable();
            $table->date('start_date');
            $table->date('target_delivery_date');
            $table->string('status')->default('In Progress'); // Not Started, In Progress, Testing, Completed, On Hold
            $table->string('priority')->default('Normal'); // Normal, High, Urgent
            $table->string('quotation_file')->nullable();
            $table->string('total_cost')->nullable();
            $table->string('stack_frontend')->nullable();
            $table->string('stack_backend')->nullable();
            $table->string('stack_database')->nullable();
            $table->string('support_period')->nullable();
            $table->date('support_expiry')->nullable();
            $table->json('handover_checklist')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
