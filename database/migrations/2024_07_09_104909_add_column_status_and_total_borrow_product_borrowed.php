<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStatusAndTotalBorrowProductBorrowed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_peminjam', function (Blueprint $table) {
            //
            $table->integer('total_barang_dipinjam')->nullable();
            $table->string('status_barang_kembali')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_peminjam', function (Blueprint $table) {
            //
            $table->dropColumn('total_barang_dipinjam');
            $table->dropColumn('status_barang_kembali');
        });
    }
}
