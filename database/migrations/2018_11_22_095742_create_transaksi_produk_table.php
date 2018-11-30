<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_produk', function (Blueprint $table) {
            $table->bigInteger('transaksi_id')
                ->unsigned()
                ->index();
            $table->foreign('transaksi_id')
                ->references('id')
                ->on('transaksi')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('produk_id')
                ->unsigned()
                ->index();
            $table->foreign('produk_id')
                ->references('id')
                ->on('produk')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('harga');
            $table->integer('jumlah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_produk');
    }
}
