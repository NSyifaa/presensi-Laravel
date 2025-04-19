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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->string('nama_siswa');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('no_telp', 15);
            $table->enum('stat', ['A', 'T']);
            $table->text('foto')->nullable();
            $table->string('kode_jurusan', 10);
            $table->timestamps();

            $table->foreign('kode_jurusan')->references('kode_jurusan')->on('jurusan')->onUpdate('cascade')->onDelete('restrict');
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
