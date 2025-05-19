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
        Schema::create('kelas_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kls_jurusan');
            $table->string('nis', 20);
            $table->timestamps();

            $table->foreign('id_kls_jurusan')->references('id')->on('ta_kelas_jurusan')->onDelete('cascade');
            $table->foreign('nis')->references('nis')->on('siswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_siswa');
    }
};
