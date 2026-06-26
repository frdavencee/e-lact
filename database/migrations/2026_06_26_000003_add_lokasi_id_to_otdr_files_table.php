<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('otdr_files', function (Blueprint $table) {
            $table->unsignedBigInteger('lokasi_id')->nullable()->after('id');
            $table->foreign('lokasi_id')->references('id')->on('locations')->cascadeOnDelete();
            $table->index('lokasi_id');
        });

        DB::statement('
            UPDATE otdr_files otf
            JOIN projects p ON p.id = otf.project_id
            SET otf.lokasi_id = p.location_id
            WHERE otf.lokasi_id IS NULL
        ');
    }

    public function down(): void
    {
        Schema::table('otdr_files', function (Blueprint $table) {
            $table->dropForeign(['lokasi_id']);
            $table->dropIndex(['lokasi_id']);
            $table->dropColumn('lokasi_id');
        });
    }
};
