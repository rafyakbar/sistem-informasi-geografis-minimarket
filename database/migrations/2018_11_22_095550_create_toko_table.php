<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toko', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('perusahaan_id');
            $table->foreign('perusahaan_id')
                ->references('id')
                ->on('perusahaan')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('negara')
                ->default('');
            $table->string('provinsi')
                ->default('');
            $table->string('kota')
                ->default('');
            $table->string('kecamatan')
                ->default('');
            $table->text('alamat');
            $table->string('lat');
            $table->string('lng');
            $table->text('catatan')
                ->nullable();
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
        Schema::dropIfExists('toko');
    }
}
