<?php

namespace App\Http\Controllers;

use App\Supports\OpenStreetMaps;
use Illuminate\Http\Request;
use Geocoder\Query\GeocodeQuery;

class PerusahaanController extends Controller
{
    public function index()
    {
        dd(OpenStreetMaps::geocode('surabaya'));

        return view('perusahaan');
    }
}
