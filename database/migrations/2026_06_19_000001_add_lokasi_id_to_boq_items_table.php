<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('boq_items', function (Blueprint $table) {
            $table->foreignId('lokasi_id')->nullable()->constrained('locations')->cascadeOnDelete()->after('project_id');
            $table->index('lokasi_id');
        });
    }

    public function down(): void
    {
        Schema::table('boq_items', function (Blueprint $table) {
            $table->dropForeign(['lokasi_id']);
            $table->dropColumn(['lokasi_id']);
        });
    }
};
