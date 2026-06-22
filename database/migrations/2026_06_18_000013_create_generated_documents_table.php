<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('generated_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('generated_by')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['docx', 'pdf'])->index();
            $table->string('file_path');
            $table->string('original_name');
            $table->unsignedInteger('version')->default(1);
            $table->unsignedBigInteger('file_size')->default(0);
            $table->timestamp('generated_at');
            $table->timestamps();

            $table->unique(['project_id', 'type', 'version']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generated_documents');
    }
};
