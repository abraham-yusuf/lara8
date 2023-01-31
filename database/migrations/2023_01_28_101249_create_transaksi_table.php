<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string("nomer_faktur")->unique();
            $table->string('nik', 50);
            $table->unsignedBigInteger("kasir");
            $table->date("tanggal_transaksi");
            $table->integer("total_harga");
            $table->enum("status_transaksi", ['tertunda', 'sukses', "batal"]);
            $table->timestamps();

            $table->primary(['nomer_faktur']);
            $table->foreign('kasir')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('nik')->references("nik")->on("customer")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
