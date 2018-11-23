<?php

use Illuminate\Database\Seeder;
use App\Toko;
use App\Kategori;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Toko::all() as $toko){
            $kategoris = Kategori::all();
            foreach ($kategoris->random(rand($kategoris->count() - 3, $kategoris->count())) as $kategori){
                $barangs = $kategori->getBarang(false);
                $max = $barangs->count() <= 10 ? rand(1,$barangs->count()) : rand(10, 14);
                foreach ($barangs->random($max) as $barang){
                    $toko->getProduk()->attach($barang, [
                        'harga' => (rand(1, 50) * 1000) + (rand(1,9) * 100)
                    ]);
                }
            }
        }
    }
}
