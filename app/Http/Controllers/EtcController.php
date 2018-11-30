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
        $max_barang = (Perusahaan::count() > Kategori::count()) ? Perusahaan::count() : Kategori::count();
        return view('etc', [
            'perusahaans' => Perusahaan::query()->orderBy('nama')->get(),
            'barangs' => Barang::query()->orderBy('kategori_id')->orderBy('nama')->paginate($max_barang - 1)->appends($request->all()),
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
        Perusahaan::query()->find(decrypt($request->id))->delete();

        return back();
    }

    public function barangEdit(Request $request)
    {
        Barang::query()->find($request->id)->update($request->all());

        return back();
    }

    public function barangDelete(Request $request)
    {
        Barang::query()->find(decrypt($request->id))->delete();

        return back();
    }

    public function barangStore(Request $request)
    {
        foreach (explode(PHP_EOL, $request->nama) as $bk){
            $exploded = explode(';', $bk);

            if (!Kategori::check($exploded[1])){
                $kategori = Kategori::create([
                    'nama' => $exploded[1]
                ]);
            } else {
                $kategori = Kategori::where('nama', $exploded[1])
                    ->first();
            }

            Barang::create([
                'kategori_id' => $kategori->id,
                'nama' => $exploded[0]
            ]);
        }

        return back();
    }

    public function kategoriStore(Request $request)
    {
        foreach (explode(PHP_EOL, $request->nama) as $nama){
            Kategori::query()->create([
                'nama' => $nama
            ]);
        }

        return back();
    }

    public function kategoriEdit(Request $request)
    {
        Kategori::query()->find($request->id)->update([
            'nama' => $request->nama
        ]);

        return back();
    }

    public function kategoriDelete(Request $request)
    {
        Kategori::query()->find(decrypt($request->id))->delete();

        return back();
    }
}
