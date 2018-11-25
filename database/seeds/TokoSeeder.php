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

        foreach (Perusahaan::all() as $perusahaan){
            for ($c = 0; $c < rand(10, 20); $c++){
                Toko::create([
                    'perusahaan_id' => $perusahaan->id,
                    'negara' => 'Indonesia',
                    'provinsi' => ['Jawa Timur', 'Jawa Tengah', 'Jawa Barat', 'DKI Jakarta'][rand(0, 3)],
                    'kota' => $faker->city,
                    'kecamatan' => $faker->citySuffix,
                    'alamat' => $faker->address,
                    'lat' => $faker->latitude,
                    'lng' => $faker->longitude,
                ]);
            }
        }
    }
}
