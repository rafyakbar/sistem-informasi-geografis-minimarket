<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Toko;
use App\Perusahaan;

class HomeController extends Controller
{

    public function index()
    {
        $daftarToko = Toko::with('getPerusahaan')->get();

        $daftarToko->map(function ($toko) {
            $toko->transaksi_per_jam = collect($toko->getRingkasanTransaksi('jam'))->values();
        });

        return view('welcome', [
            'daftarToko' => $daftarToko,
            'daftarPerusahaan' => Perusahaan::all()
        ]);
    }

}
