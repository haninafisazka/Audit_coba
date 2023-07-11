<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodeAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periode_audits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tanggal_awal_audit');
            $table->date('tanggal_akhir_audit');
            $table->string('no_sk_tugas_audit', 100);
            $table->string('file_sk', 100);
            $table->date('tanggal_sk');
            $table->string('ketua_spi', 100);
            $table->string('nip_ketua_spi', 10);
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
        Schema::dropIfExists('periode_audits');
    }
}
