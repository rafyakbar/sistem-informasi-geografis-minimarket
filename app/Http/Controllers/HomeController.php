<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Toko;
use App\Perusahaan;

class HomeController extends Controller
{

    public function index()
    {
        return view('welcome', [
            'daftarPerusahaan' => Perusahaan::all()
        ]);
    }

    public function fetchData()
    {
        $daftarToko = Toko::with('getPerusahaan')->with('getFoto')->get();

        $daftarToko->map(function ($toko) {
            $toko->transaksi_per_jam = collect($toko->getRingkasanTransaksi('jam'))->values();
            $toko->jumlah_transaksi = $toko->getJumlahTransaksiMingguTerakhir();
            if (!is_null($toko->get_foto)) {
                $toko->get_foto->map(function ($item) {
                    $item->dir = asset($item->dir);
                });
            }
        });

        return response()->json($daftarToko);
    }

}
