<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDetailBorrowed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_peminjam', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_pinjam_id')->required();
            $table->foreign('product_pinjam_id')->references('id')->on('barang_pinjam');

            $table->unsignedBigInteger('peminjaman_id')->required();
            $table->foreign('peminjaman_id')->references('id')->on('peminjaman');

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
        Schema::dropIfExists('detail_peminjam');
    }
}
