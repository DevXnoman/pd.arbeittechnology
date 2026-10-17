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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('niche')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->json('work_scope')->nullable(); // Multi-select tags e.g. ["MERN", "Laravel", "WordPress"]
            $table->date('lead_incoming_date')->nullable();
            $table->string('quoted_amount')->nullable(); // String to support ranges like "20000-25000" or "৳115,000"
            $table->string('sold_amount')->nullable();
            $table->string('status')->default('New Lead'); // Manually typed status string
            $table->string('campaign_month'); // e.g., "August 2026 (2nd Ad)", "August 2026", "July 2026"
            $table->string('assigned_to')->nullable();
            $table->text('note')->nullable(); // Free-text observation note
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete(); // Link when converted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
