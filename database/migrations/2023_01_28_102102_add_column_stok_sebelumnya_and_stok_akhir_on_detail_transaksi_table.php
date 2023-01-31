<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStokSebelumnyaAndStokAkhirOnDetailTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->integer("stok_sebelumnya")->after("harga_satuan");
            $table->integer("sisa_stok")->after("jumlah");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->dropColumn("stok_sebelumnya");
            $table->dropColumn("sisa_stok");
        });
    }
}
