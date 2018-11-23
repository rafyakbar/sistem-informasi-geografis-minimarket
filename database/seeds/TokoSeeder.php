<?php

use Illuminate\Database\Seeder;
use App\Perusahaan;
use App\Toko;
use Faker\Factory;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        $jumlah_toko = rand(400, 500);
        foreach (Perusahaan::all() as $perusahaan){
            for ($c = 0; $c < $jumlah_toko; $c++){
                Toko::create([
                    'perusahaan_id' => $perusahaan->id,
                    'alamat' => $faker->address,
                    'lat' => $faker->latitude,
                    'lng' => $faker->longitude,
                    'luas_tanah' => rand(10,20) * 10,
                    'waktu_buka' => json_encode([
                        'senin' => [
                            '05:00:00-23:00:00'
                        ],
                        'selasa' => [
                            '05:00:00-23:00:00'
                        ],
                        'rabu' => [
                            '05:00:00-23:00:00'
                        ],
                        'kamis' => [
                            '05:00:00-23:00:00'
                        ],
                        'jumat' => [
                            '05:00:00-11:00:00',
                            '13:00:00-23:00:00'
                        ],
                        'sabtu' => [
                            '05:00:00-23:00:00'
                        ],
                        'minggu' => [
                            '05:00:00-23:59:59'
                        ],
                    ])
                ]);
            }
            $jumlah_toko -= rand(40, 80);
        }
    }
}
