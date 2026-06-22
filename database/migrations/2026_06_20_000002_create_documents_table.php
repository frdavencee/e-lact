<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('status', 50)->default('draft');
            $table->string('current_step', 50)->default('commissioning');
            $table->json('data')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['project_id', 'status']);
        });

        Schema::table('commissioning_tests', function (Blueprint $table) {
            if (!Schema::hasColumn('commissioning_tests', 'project_id')) {
                $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('commissioning_tests', 'project')) {
                $table->foreignId('project')->nullable()->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('commissioning_tests', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('commissioning_tests', 'signature_path')) {
                $table->string('signature_path')->nullable();
            }
        });

        Schema::table('approvals', function (Blueprint $table) {
            if (Schema::hasColumn('approvals', 'project_id')) {
                $table->dropForeign(['project_id']);
                $table->dropColumn('project_id');
            }
            $table->string('approvable_type')->default('App\Models\Project');
            $table->unsignedBigInteger('approvable_id');
            $table->index(['approvable_type', 'approvable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
