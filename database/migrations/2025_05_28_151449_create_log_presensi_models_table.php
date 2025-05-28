<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_presensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_presensi');
            $table->string('nis', 20);
            $table->enum('status', ['Hadir', 'Alpa', 'Izin', 'Sakit']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_presensi');
    }
};
