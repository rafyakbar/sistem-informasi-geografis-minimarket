<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('barang_id')->unsigned();
            $table->foreign('barang_id')
                ->references('id')
                ->on('barang')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('toko_id')->unsigned();
            $table->foreign('toko_id')
                ->references('id')
                ->on('toko')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('harga');
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
        Schema::dropIfExists('produk');
    }
}
