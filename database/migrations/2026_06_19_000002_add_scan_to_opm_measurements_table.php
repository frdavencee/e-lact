<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opm_measurements', function (Blueprint $table) {
            $table->enum('scan', ['sudah', 'belum'])->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('opm_measurements', function (Blueprint $table) {
            $table->dropColumn('scan');
        });
    }
};
