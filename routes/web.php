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

Route::get('/fetch-data', 'HomeController@fetchData')->name('fetch.data');

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

        Route::group(['prefix' => 'foto'], function () {
            Route::get('{id}/{no}', [
                'uses' => 'TokoController@foto',
                'as' => 'admin.toko.foto'
            ]);

            Route::post('store', [
                'uses' => 'TokoController@fotoStore',
                'as' => 'admin.toko.foto.store'
            ]);

            Route::get('delete', [
                'uses' => 'TokoController@fotoDelete',
                'as' => 'admin.toko.foto.delete'
            ]);
        });
    });

    Route::group(['prefix' => 'perusahaan'], function () {
        Route::post('store', [
            'uses' => 'EtcController@perusahaanStore',
            'as' => 'admin.perusahaan.store'
        ]);

        Route::post('edit', [
            'uses' => 'EtcController@perusahaanEdit',
            'as' => 'admin.perusahaan.edit'
        ]);

        Route::get('delete/{id}', [
            'uses' => 'EtcController@perusahaanDelete',
            'as' => 'admin.perusahaan.delete'
        ]);
    });

    Route::group(['prefix' => 'barang'], function () {
        Route::post('edit', [
            'uses' => 'EtcController@barangEdit',
            'as' => 'admin.barang.edit'
        ]);

        Route::get('delete/{id}', [
            'uses' => 'EtcController@barangDelete',
            'as' => 'admin.barang.delete'
        ]);

        Route::post('store', [
            'uses' => 'EtcController@barangStore',
            'as' => 'admin.barang.store'
        ]);
    });

    Route::group(['prefix' => 'kategori'], function () {
        Route::post('store', [
            'uses' => 'EtcController@kategoriStore',
            'as' => 'admin.kategori.store'
        ]);

        Route::post('edit', [
            'uses' => 'EtcController@kategoriEdit',
            'as' => 'admin.kategori.edit'
        ]);

        Route::get('delete/{id}', [
            'uses' => 'EtcController@kategoriDelete',
            'as' => 'admin.kategori.delete'
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

    Route::get('barang/populer/{toko}', [
        'uses' => 'TokoController@barangPopuler',
        'as' => 'toko.barang.populer'
    ]);

});
