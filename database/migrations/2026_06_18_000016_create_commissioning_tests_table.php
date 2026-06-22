<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commissioning_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lokasi_id')->constrained('locations')->cascadeOnDelete();
            $table->foreignId('personel_id')->constrained('waspangs')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('kota_ttd', 100);
            $table->enum('status_pekerjaan', ['telah', 'belum'])->default('belum');
            $table->enum('status_hasil', ['dapat', 'tidak_dapat'])->default('dapat');
            $table->enum('status_kelayakan', ['layak', 'tidak_layak'])->default('layak');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commissioning_tests');
    }
};
