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
        Schema::create('kbm', function (Blueprint $table) {
            $table->id();
            $table->char('hari', 1);
            $table->string('jam_mulai');
            $table->string('jam_selesai');
            $table->unsignedBigInteger('id_mapel');
            $table->unsignedBigInteger('id_kls_jurusan');
            $table->string('nip', 20);
            $table->unsignedBigInteger('id_ta');
            $table->timestamps();

            $table->foreign('id_mapel')->references('id')->on('mapel')->onDelete('cascade');
            $table->foreign('id_kls_jurusan')->references('id')->on('ta_kelas_jurusan')->onDelete('cascade');
            $table->foreign('nip')->references('nip')->on('guru')->onDelete('cascade');
            $table->foreign('id_ta')->references('id')->on('tahun_ajaran')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kbm');
    }
};
