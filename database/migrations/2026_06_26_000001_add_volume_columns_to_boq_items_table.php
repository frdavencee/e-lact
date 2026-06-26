<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('boq_items', function (Blueprint $table) {
            $table->float('volume_drm')->nullable()->after('volume');
            $table->float('volume_aktual')->nullable()->after('volume_drm');
            $table->float('volume_tambah')->nullable()->after('volume_aktual');
            $table->float('volume_kurang')->nullable()->after('volume_tambah');
        });
    }

    public function down(): void
    {
        Schema::table('boq_items', function (Blueprint $table) {
            $table->dropColumn(['volume_drm', 'volume_aktual', 'volume_tambah', 'volume_kurang']);
        });
    }
};
