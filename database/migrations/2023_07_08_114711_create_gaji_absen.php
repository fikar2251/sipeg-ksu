<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gaji_absen', function (Blueprint $table) {
            $table->id();
            $table->integer('kode_absen');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('tanggal');
            $table->time('masuk');
            $table->time('keluar');
            $table->string('nik_pegawai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gaji_absen');
    }
};
