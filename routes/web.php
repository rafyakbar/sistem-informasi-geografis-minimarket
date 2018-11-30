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

Route::get('/', [
    'uses' => 'HomeController@index',
    'as' => 'index'
]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('dashboard', function () {
        return redirect()->route('admin.perusahaan');
    })->name('admin.dashboard');


    Route::get('etc', [
        'uses' => 'EtcController@index',
        'as' => 'admin.etc'
    ]);

    Route::group(['prefix' => 'toko'], function () {
        Route::get('', [
            'uses' => 'TokoController@index',
            'as' => 'admin.toko'
        ]);

        Route::post('store', [
            'uses' => 'TokoController@store',
            'as' => 'admin.toko.store'
        ]);

        Route::post('store/many', [
            'uses' => 'TokoController@storeMany',
            'as' => 'admin.toko.store.many'
        ]);

        Route::post('update', [
            'uses' => 'TokoController@update',
            'as' => 'admin.toko.update'
        ]);

        Route::get('delete/{id}', [
            'uses' => 'TokoController@delete',
            'as' => 'admin.toko.delete'
        ]);
    });

    Route::get('geocode', [
        'uses' => 'TokoController@geocode',
        'as' => 'admin.geocode'
    ]);

    Route::get('reverse', [
        'uses' => 'TokoController@reverse',
        'as' => 'admin.reverse'
    ]);
});


Route::prefix('toko')->group(function () {

    Route::get('ringkasan/transaksi/harijam/{toko}', [
        'uses' => 'TokoController@ringkasanTransaksiPerHariPerJam',
        'as' => 'ringkasan.transaksi.perhariperjam'
    ]);

    Route::get('ringkasan/transaksi/jam/{toko}', [
        'uses' => 'TokoController@ringkasanTransaksiPerJam',
        'as' => 'ringkasan.transaksi.perjam'
    ]);

    Route::get('ringkasan/transaksi/hari/{toko}', [
        'uses' => 'TokoController@ringkasanTransaksiPerHari',
        'as' => 'ringkasan.transaksi.perhari'
    ]);

});
