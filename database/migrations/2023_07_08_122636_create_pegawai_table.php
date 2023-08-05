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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip_pegawai');
            $table->integer('kode_absen');
            $table->string('alamat');
            $table->string('jenis_kelamin');
            $table->integer('ktp');
            $table->integer('bpjs_kes');
            $table->integer('bpjs_ket');
            $table->integer('status_pegawai');
            $table->integer('ptkp');
            $table->integer('jabatan');
            $table->integer('gaji_pokok');
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
        Schema::dropIfExists('pegawai');
    }
};
