<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->string('kode_barang', 50)->unique();
            $table->string('nama', 200);
            $table->integer('jumlah');
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('satuan_id');
            $table->text("notif")->nullable();
            // $table->date("tanggal_kadaluarsa");
            $table->timestamps();

            $table->primary(['kode_barang']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
