<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonfirmasiOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konfirmasi_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('id_perusahaan_ditagihkan');
            $table->integer('id_perusahaan_diverifikasi');
            $table->integer('id_jenis_jasa');
            $table->date('tanggal');
            $table->string('nomor');
            $table->integer('objek_order');
            $table->integer('waktu_pelaksanaan');
            $table->text('keterangan');
            $table->decimal('total_biaya', $precision = 20, $scale = 2);
            $table->string('dibebankan_kepada');
            $table->text('referensi');
            $table->tinyInteger('status')->default('0');
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
        Schema::dropIfExists('konfirmasi_orders');
    }
}
