<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPengadaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_pengadaans', function (Blueprint $table) {
            $table->id('id');
            $table->string('pengadaan_id')->nullable();
            $table->string('nama_gudang')->nullable();
            $table->string('supplier')->nullable();
            $table->string('status_pengadaan')->nullable();
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('order_pengadaans');
    }
}
