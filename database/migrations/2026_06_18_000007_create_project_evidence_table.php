<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_evidence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->enum('category', [
                'penarikan_kabel',
                'instalasi_aksesoris',
                'closure',
                'penyambungan_odp',
                'marking_kabel',
                'odp',
                'pu_as_hl',
                'pu_as_sc',
                'splitter',
                'opm',
                'otdr',
                'mancore',
                'as_build_drawing',
                'boq',
            ])->index();
            $table->string('file_path');
            $table->string('original_name');
            $table->string('mime_type', 120);
            $table->unsignedBigInteger('size')->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_evidence');
    }
};
