<?php

namespace App\Http\Controllers;

use App\Perusahaan;
use App\Supports\OpenStreetMaps;
use App\Toko;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    public function index(Request $request)
    {
//        dd(OpenStreetMaps::geocode('Surabaya, jawa timur'));
        $tokos = Toko::query()->when($request->perusahaan, function ($query) use ($request) {
            $query->whereHas('getPerusahaan', function ($query) use ($request){
                $query->where('nama', $request->perusahaan);
            });
        })->when($request->npkk, function ($query) use ($request) {
            foreach (explode('|', $request->npkk) as $npkk){
                $query->where(function ($query) use ($request, $npkk) {
                    $exploded = explode(',', $npkk);

                    $negara = $exploded[0];
                    $provinsi = $exploded[1];
                    $kota = $exploded[2];
                    $kecamatan = $exploded[3];

                    if (!empty($negara))
                        $query->where('negara', 'ILIKE', '%'.$negara.'%');
                    if (!empty($provinsi))
                        $query->where('provinsi', 'ILIKE', '%'.$provinsi.'%');
                    if (!empty($kota))
                        $query->where('kota', 'ILIKE', '%'.$kota.'%');
                    if (!empty($kecamatan))
                        $query->where('kecamatan', 'ILIKE', '%'.$kecamatan.'%');
                });
            }
        })
//            ->toSql();
//        dd($tokos);
            ->orderBy('created_at')
            ->paginate(10)
            ->appends($request->all());

        return view('toko', [
            'tokos' => $tokos,
            'perusahaans' => Perusahaan::orderBy('nama')->get(),
            'perusahaan' => $request->perusahaan,
            'npkk' => $request->npkk
        ]);
    }

    public function geocode(Request $request)
    {
        return json_encode(OpenStreetMaps::geocode($request->alamat));
    }
}
