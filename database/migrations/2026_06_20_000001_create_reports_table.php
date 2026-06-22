<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 255);
            $table->string('type', 100)->default('lapangan');
            $table->text('description')->nullable();
            $table->date('report_date')->nullable();
            $table->string('location', 255)->nullable();
            $table->string('pd_staff', 255)->nullable();
            $table->text('findings')->nullable();
            $table->text('recommendations')->nullable();
            $table->text('action_plan')->nullable();
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();

            $table->index(['project_id', 'created_at']);
            $table->index(['type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
