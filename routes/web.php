<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('dashboard', function () {
        return redirect()->route('admin.perusahaan');
    })->name('admin.dashboard');


    Route::get('perusahaan', [
        'uses' => 'PerusahaanController@index',
        'as' => 'admin.perusahaan'
    ]);

    Route::get('toko', [
        'uses' => 'TokoController@index',
        'as' => 'admin.toko'
    ]);

    Route::get('geocode', [
        'uses' => 'TokoController@geocode',
        'as' => 'admin.geocode'
    ]);
});
