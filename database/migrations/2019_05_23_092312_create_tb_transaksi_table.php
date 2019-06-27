<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_agenda')->unsigned();
            $table->string('description');
            $table->string('lokasi_laporan');
            $table->string('tanggal_kerjakan');
            $table->string('status');
            $table->timestamps();

            $table->foreign('id_agenda')->references('id')->on('tb_konten_agenda')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_transaksi');
    }
}
