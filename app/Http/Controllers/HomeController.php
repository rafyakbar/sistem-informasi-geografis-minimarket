<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Toko;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'daftarToko' => Toko::all()
        ]);
    }
}
