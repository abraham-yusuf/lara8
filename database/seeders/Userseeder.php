<?php

namespace Database\Seeders;

// use user dari model
use App\Models\User;
use Illuminate\Database\Seeder;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            "nama" => "Administrasi",
            "username" => "administrasi",
            "email" => "administrasi@mail.com",
            "password" => bcrypt('123456'),
            "role" => "administrasi",
            "nomer_tlpn" => "0896726478264",
            "status_aktif" => "aktif",
            "avatar" => "",
        ]);
        User::create([
            "nama" => "Gudang",
            "username" => "gudang",
            "email" => "gudang@mail.com",
            "password" => bcrypt('123456'),
            "nomer_tlpn" => "0896728274",
            "role" => "gudang",
            "status_aktif" => "aktif",
            "avatar" => "",
        ]);

        User::create([
            "nama" => "Manager",
            "username" => "manager",
            "email" => "manager@mail.com",
            "password" => bcrypt('123456'),
            "nomer_tlpn" => "089672884033",
            "role" => "manager",
            "status_aktif" => "aktif",
            "avatar" => "",
        ]);
        User::create([
            "nama" => "kasir",
            "username" => "kasir",
            "email" => "kasir@mail.com",
            "password" => bcrypt('123456'),
            "nomer_tlpn" => "089673434334",
            "role" => "kasir",
            "status_aktif" => "aktif",
            "avatar" => "",
        ]);
    }
}
