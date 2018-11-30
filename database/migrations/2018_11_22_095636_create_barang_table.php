<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id')
                ->index();
            $table->integer('kategori_id')
                ->unsigned();
            $table->foreign('kategori_id')
                ->references('id')
                ->on('kategori')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('nama')
                ->unique()
                ->index();
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
        Schema::dropIfExists('barang');
    }
}
