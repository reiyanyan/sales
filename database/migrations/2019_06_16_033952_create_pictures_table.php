<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('laporan_id')->unsigned();
            $table->string('foto');
            $table->timestamps();

            $table->foreign('laporan_id')->references('id')->on('tb_transaksi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_pictures');
    }
}
