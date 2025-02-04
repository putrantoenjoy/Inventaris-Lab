<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id');
            $table->integer('nama_gudang')->nullable();
            $table->string('supplier')->nullable();
            $table->string('status_pengadaan')->nullable();
            $table->string('dokumen')->nullable();
            $table->string('product')->nullable();
            $table->string('product_kode')->nullable();
            $table->string('jumlah_product')->nullable();
            $table->string('harga')->nullable();
            $table->string('subtotal')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
