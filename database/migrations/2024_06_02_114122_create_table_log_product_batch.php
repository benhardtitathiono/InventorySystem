<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLogProductBatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_product_batch', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->required();
            $table->foreign('product_id')->references('id')->on('product_abis_pakai');

            $table->unsignedBigInteger('batch_product')->required();
            $table->foreign('batch_product')->references('id')->on('batch_product');

            $table->integer('quantity_in')->nullable();
            $table->integer('quantity_out')->nullable();
            $table->date('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_product_batch');
    }
}
