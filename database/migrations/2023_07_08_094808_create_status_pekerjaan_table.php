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
        Schema::create('status_pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('gaji_pokok');
            $table->integer('uang_makan');
            $table->integer('uang_transport');
            $table->integer('premi_bpjs_kes_max');
            $table->integer('premi_bpjs_kes_min');
            $table->integer('premi_jp_max');
            $table->integer('premi_jp_min');
            $table->integer('premi_jp_nilai');
            $table->integer('pot_bpjs_ket');
            $table->integer('pot_bpjs_kes_max');
            $table->integer('pot_bpjs_kes_min');
            $table->integer('pot_jp_max');
            $table->integer('pot_jp_min');
            $table->integer('pot_jp_nilai');
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
        Schema::dropIfExists('status_pekerjaan');
    }
};
