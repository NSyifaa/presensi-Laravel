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
        Schema::table('guru', function (Blueprint $table) {
            $table->string('provinsi_id')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten_id')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan_id')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa_id')->nullable();
            $table->string('desa')->nullable();
        });
    }
};
