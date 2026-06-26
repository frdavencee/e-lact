<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opm_measurements', function (Blueprint $table) {
            $table->unsignedBigInteger('lokasi_id')->nullable()->after('id');
            $table->foreign('lokasi_id')->references('id')->on('locations')->cascadeOnDelete();
            $table->index('lokasi_id');
        });

        // Backfill lokasi_id dari project->location_id untuk data yang sudah ada
        DB::statement('
            UPDATE opm_measurements om
            JOIN projects p ON p.id = om.project_id
            SET om.lokasi_id = p.location_id
            WHERE om.lokasi_id IS NULL
        ');
    }

    public function down(): void
    {
        Schema::table('opm_measurements', function (Blueprint $table) {
            $table->dropForeign(['lokasi_id']);
            $table->dropIndex(['lokasi_id']);
            $table->dropColumn('lokasi_id');
        });
    }
};
