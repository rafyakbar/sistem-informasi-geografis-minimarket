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
            'daftarToko' => Toko::with('getPerusahaan')->get(),
            'daftarPerusahaan' => Perusahaan::all()
        ]);
    }
}
