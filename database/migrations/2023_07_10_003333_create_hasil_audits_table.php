<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_audits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_standar_ruang_lingkup');
            $table->foreign('id_standar_ruang_lingkup')->references('id')->on('standar_ruang_lingkups')->onDelete('cascade');
            $table->text('kondisi_awal');
            $table->text('dasar_evaluasi');
            $table->text('penyebab');
            $table->text('akibat');
            $table->text('feedback');
            $table->date('tanggal_kesanggupan_penyelesaian');
            $table->text('rekomendasi_follow_up');
            $table->text('tindak_lanjut');
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
        Schema::dropIfExists('hasil_audits');
    }
}
