<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foto', function (Blueprint $table) {
            $table->bigIncrements('id')
                ->index();
            $table->bigInteger('toko_id')
                ->unsigned()
                ->index();
            $table->foreign('toko_id')
                ->references('id')
                ->on('toko')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('dir');
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
        Schema::dropIfExists('foto');
    }
}
