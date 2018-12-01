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
            $k = rand(0,2);
            for ($c = 1; $c <= 30; $c++){
                for ($i = 7; $i <= 20; $i++){
                    for ($j = 0; $j < $this->keadaan($k);$j++){
                        $transaksi = Transaksi::create([
                            'toko_id' => $toko->id,
                            'created_at' => $created_at = Carbon::today()->addDays(-$c)
                                ->addHours($i)
                                ->addMinutes(rand(0, 59))
                                ->addSeconds(rand(0,59)),
                            'updated_at' => $created_at
                        ]);

                        foreach ($produk->random(rand(1, 3)) as $barang){
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

    public function keadaan($tipe)
    {
        if ($tipe == 0)
            return rand(5, 10);
        elseif ($tipe == 1)
            return rand(15,25);
        return rand(30,45);
    }
}
