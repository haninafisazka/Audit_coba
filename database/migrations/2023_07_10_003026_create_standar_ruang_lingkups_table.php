<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandarRuangLingkupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standar_ruang_lingkups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_setup_file');
            $table->foreign('id_setup_file')->references('id')->on('setup_files')->onDelete('cascade');
            $table->string('nama_ruang_lingkup', 100);
            $table->text('deskripsi_ruang_lingkup', 255);
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
        Schema::dropIfExists('standar_ruang_lingkups');
    }
}
