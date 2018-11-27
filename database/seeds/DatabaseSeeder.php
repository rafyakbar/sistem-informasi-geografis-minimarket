<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Eloquent\Model::unguard();

        $this->call(UserSeeder::class);
        $this->call(PerusahaanSeeder::class);
//        $this->call(TokoSeeder::class);
        $this->call(KategoriBarangSeeder::class);
//        $this->call(ProdukSeeder::class);
//        $this->call(TransaksiSeeder::class);
    }
}
