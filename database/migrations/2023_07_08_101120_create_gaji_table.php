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
        Schema::create('gaji', function (Blueprint $table) {
            $table->id();
            $table->string('nik_pegawai');
            $table->integer('kode_absen');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('uang_makan');
            $table->integer('uang_transport');
            $table->integer('adjustment');
            $table->integer('premi_bpjs_kes');
            $table->integer('premi_bpjs_ket');
            $table->integer('premi_jp');
            $table->integer('pot_bpjs_ket');
            $table->integer('pot_bpjs_kes');
            $table->integer('pot_jp');
            $table->integer('pinjaman');
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
        Schema::dropIfExists('gaji');
    }
};
