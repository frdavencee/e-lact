<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waspangs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('nik', 20)->unique();
            $table->string('position', 100)->default('WASPANG');
            $table->string('phone', 30)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waspangs');
    }
};
