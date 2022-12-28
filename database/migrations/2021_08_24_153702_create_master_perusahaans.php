<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterPerusahaans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_perusahaans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('alamat_pusat');
            $table->string('provinsi_pusat');
            $table->string('kabupaten_pusat');
            $table->string('kecamatan_pusat');
            $table->string('kelurahan_pusat');
            $table->string('email_pusat');
            $table->text('alamat_pabrik');
            $table->string('provinsi_pabrik');
            $table->string('kabupaten_pabrik');
            $table->string('kecamatan_pabrik');
            $table->string('kelurahan_pabrik');
            $table->string('email_pabrik');
            $table->string('status');
            $table->string('pejabat');
            $table->string('jabatan');
            $table->string('akta_pendirian');
            $table->string('npwp');
            $table->string('ijin_usaha');
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
        Schema::dropIfExists('master_perusahaans');
    }
}
