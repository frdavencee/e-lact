<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('location_id')->constrained('locations')->cascadeOnDelete();
            $table->foreignId('waspang_id')->nullable()->constrained('waspangs')->nullOnDelete();

            $table->string('name', 255);
            $table->string('sp_number', 150)->nullable();
            $table->string('contract_number', 150)->nullable();
            $table->string('purchase_order_number', 150)->nullable();
            $table->date('sp_date')->nullable();
            $table->date('commissioning_date')->nullable();
            $table->string('implementer', 200)->nullable();
            $table->enum('status', ['draft', 'in_progress', 'review', 'approved', 'generated', 'closed'])->default('draft');
            $table->text('notes')->nullable();

            $table->timestamp('completed_at')->nullable();
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['branch_id', 'location_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
