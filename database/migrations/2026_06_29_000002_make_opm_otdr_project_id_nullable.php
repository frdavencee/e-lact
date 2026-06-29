<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opm_measurements', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->change();
            $table->string('odp_name', 150)->nullable()->change();
        });

        Schema::table('otdr_files', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('opm_measurements', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable(false)->change();
            $table->string('odp_name', 150)->nullable(false)->change();
        });

        Schema::table('otdr_files', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable(false)->change();
        });
    }
};
