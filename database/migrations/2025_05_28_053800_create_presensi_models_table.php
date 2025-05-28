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
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kbm');
            $table->char('pertemuan_ke', 2);
            $table->date('tanggal');
            $table->enum('ket', ['A', 'T']);
            $table->timestamps();

            $table->foreign('id_kbm')->references('id')->on('kbm')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
