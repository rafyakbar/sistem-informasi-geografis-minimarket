<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Kategori;
use App\Perusahaan;
use Illuminate\Http\Request;

class EtcController extends Controller
{
    public function index(Request $request)
    {
        return view('etc', [
            'perusahaans' => Perusahaan::query()->orderBy('nama')->get(),
            'barangs' => Barang::query()->paginate(20)->appends($request->all()),
            'kategoris' => Kategori::query()->orderBy('nama')->get()
        ]);
    }

    public function perusahaanStore(Request $request)
    {
        foreach (explode(PHP_EOL, $request->nama) as $nama){
            Perusahaan::query()->create([
                'nama' => $nama
            ]);
        }

        return back();
    }

    public function perusahaanEdit(Request $request)
    {
        Perusahaan::query()->find($request->id)->update([
            'nama' => $request->nama
        ]);

        return back();
    }

    public function perusahaanDelete(Request $request)
    {
        Perusahaan::query()->find($request->id)->delete();

        return back();
    }
}
