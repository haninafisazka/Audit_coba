<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_audits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_periode_audit');
            $table->unsignedBigInteger('id_standar_ruang_lingkup');
            $table->string('nama_unit', 100);
            $table->date('tanggal_audit');
            $table->string('ketua_tim', 100);
            $table->string('nip_ketua_tim', 10);
            $table->foreign('id_periode_audit')->references('id')->on('periode_audits')->onDelete('cascade');
            $table->foreign('id_standar_ruang_lingkup')->references('id')->on('standar_ruang_lingkups')->onDelete('cascade');
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
        Schema::dropIfExists('unit_audits');
    }
}
