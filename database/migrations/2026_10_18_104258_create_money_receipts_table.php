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
        Schema::create('money_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_no')->unique();
            $table->date('receipt_date');
            $table->string('client_name');
            $table->string('client_contact')->nullable();
            $table->text('client_address')->nullable();
            $table->string('purpose')->nullable();
            $table->decimal('amount_received', 12, 2)->default(0);
            $table->string('payment_method')->nullable();
            $table->decimal('due_balance', 12, 2)->default(0);
            $table->string('signatory_name')->nullable()->default('MD. Ali Akbar');
            $table->string('signatory_designation')->nullable()->default('Managing Director');
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('money_receipts');
    }
};
