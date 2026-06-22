<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('otdr_files', function (Blueprint $table) {
            $table->string('odp_name', 150)->nullable()->after('project_id');
        });
    }

    public function down(): void
    {
        Schema::table('otdr_files', function (Blueprint $table) {
            $table->dropColumn('odp_name');
        });
    }
};
