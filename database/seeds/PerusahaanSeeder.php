<?php

use Illuminate\Database\Seeder;
use App\Perusahaan;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Indomaret',
            'Alfamart',
            'Alfamidi'
        ];

        foreach ($names as $name){
            Perusahaan::create([
                'nama' => $name
            ]);
        }
    }
}
