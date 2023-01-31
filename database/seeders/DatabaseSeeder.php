<?php

namespace Database\Seeders;

// import seeder dari model
use App\Models\Satuan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $this->call([Userseeder::class, SatuanSeeder::class]);
    }
}
