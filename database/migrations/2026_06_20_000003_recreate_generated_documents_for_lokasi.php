<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('generated_documents');

        Schema::create('generated_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lokasi_id')->constrained('locations')->cascadeOnDelete();
            $table->string('generated_by');
            $table->timestamp('generated_at')->nullable();
            $table->string('file_path');
            $table->unsignedInteger('versi')->default(1);
            $table->timestamps();

            $table->index('lokasi_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generated_documents');
    }
};
