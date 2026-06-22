<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_lampiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lokasi_id')->constrained('locations')->cascadeOnDelete();
            $table->string('kategori', 100);
            $table->string('label', 255)->nullable();
            $table->string('file_path', 500);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();

            $table->index(['lokasi_id', 'kategori']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_lampiran');
    }
};
