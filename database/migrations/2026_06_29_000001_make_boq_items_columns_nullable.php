<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('boq_items', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->change();
            $table->string('name', 255)->nullable()->change();
            $table->string('unit', 50)->nullable()->change();
            $table->decimal('volume', 12, 2)->nullable()->default(null)->change();
            $table->decimal('price', 14, 2)->nullable()->default(null)->change();
            $table->decimal('total', 14, 2)->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('boq_items', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable(false)->change();
            $table->string('name', 255)->nullable(false)->change();
            $table->string('unit', 50)->nullable(false)->change();
            $table->decimal('volume', 12, 2)->default(0)->nullable(false)->change();
            $table->decimal('price', 14, 2)->default(0)->nullable(false)->change();
            $table->decimal('total', 14, 2)->default(0)->nullable(false)->change();
        });
    }
};
