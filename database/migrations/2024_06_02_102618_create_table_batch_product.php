<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBatchProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_product', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('product_id');
            // $table->foreign('product_id')->references('id')->on('product_abis_pakai');
            $table->date('tanggal_masuk');
            $table->date('tanggal_kadaluwarsa');
            $table->integer('jumlah');
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
        Schema::dropIfExists('batch_product');
    }
}
