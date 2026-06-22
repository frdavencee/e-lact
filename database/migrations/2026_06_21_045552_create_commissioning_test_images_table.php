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
        Schema::create('commissioning_test_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commissioning_test_id')->constrained('commissioning_tests')->cascadeOnDelete();
            $table->string('file_path');
            $table->string('label')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissioning_test_images');
    }
};
