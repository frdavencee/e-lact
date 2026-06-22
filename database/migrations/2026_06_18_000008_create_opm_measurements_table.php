<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opm_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('odp_name', 150);
            $table->decimal('port_1', 8, 2)->nullable();
            $table->decimal('port_2', 8, 2)->nullable();
            $table->decimal('port_3', 8, 2)->nullable();
            $table->decimal('port_4', 8, 2)->nullable();
            $table->decimal('port_5', 8, 2)->nullable();
            $table->decimal('port_6', 8, 2)->nullable();
            $table->decimal('port_7', 8, 2)->nullable();
            $table->decimal('port_8', 8, 2)->nullable();
            $table->decimal('loss_value', 8, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opm_measurements');
    }
};
