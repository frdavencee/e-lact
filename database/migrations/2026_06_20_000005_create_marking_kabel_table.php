<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marking_kabel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lokasi_id')->constrained('locations')->cascadeOnDelete();
            $table->string('jenis_kabel', 150);
            $table->decimal('panjang_meter', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marking_kabel');
    }
};
