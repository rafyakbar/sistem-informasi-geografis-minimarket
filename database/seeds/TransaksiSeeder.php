<?php

use Illuminate\Database\Seeder;
use App\Toko;
use App\Transaksi;
use Carbon\Carbon;
use App\Produk;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Toko::all() as $toko){
            $produk = $toko->getProduk(false);
            for ($c = 1; $c <= 30; $c++){
                for ($i = 0; $i < rand(10, 20); $i++){
                    $transaksi = Transaksi::create([
                        'toko_id' => $toko->id,
                        'created_at' => $created_at = Carbon::today()->addDays(-$c)->addHours(rand(5, 17))->addMinutes(rand(0, 59))->addSeconds(rand(0,59)),
                        'updated_at' => $created_at
                    ]);

                    foreach ($produk->random(rand(1, 5)) as $barang){
                        $transaksi->getTransaksiProduk()->attach(Produk::find($barang->pivot->id), [
                            'harga' => $barang->pivot->harga,
                            'jumlah' => rand(1,5)
                        ]);
                    }
                }
            }
        }
    }
}
