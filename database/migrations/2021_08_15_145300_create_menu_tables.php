<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_menu');
            $table->string('nama_menu');
            $table->string('route')->nullable();
            $table->integer('parent_id')->nullable();
            $table->tinyInteger('count_sub')->default("0");
            $table->tinyInteger('list')->default("1");
            $table->tinyInteger('create')->default("1");
            $table->tinyInteger('edit')->default("1");
            $table->tinyInteger('delete')->default("1");
            $table->tinyInteger('approval')->default("0");
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
