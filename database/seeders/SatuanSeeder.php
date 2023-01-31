<?php

namespace Database\Seeders;

// use Satuan dari model
use App\Models\Satuan;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Satuan::create([
            "satuan" => "pcs",
            "jumlah_persatuan" => 1
        ]);
        Satuan::create([
            "satuan" => "box20",
            "jumlah_persatuan" => 20
        ]);
        Satuan::create([
            "satuan" => "box25",
            "jumlah_persatuan" => 25
        ]);
        Satuan::create([
            "satuan" => "box30",
            "jumlah_persatuan" => 30
        ]);
    }
}
