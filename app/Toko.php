<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Toko extends Model
{
    protected $table = 'toko';

    protected $fillable = [
        'perusahaan_id', 'alamat', 'lat', 'lng', 'negara', 'provinsi', 'kota', 'kecamatan', 'catatan'
    ];

    /**
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getPerusahaan($queryReturn = true)
    {
        $data = $this->belongsTo(Perusahaan::class, 'perusahaan_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getProduk($queryReturn = true)
    {
        $data = $this->belongsToMany(Barang::class, 'produk', 'toko_id', 'barang_id')->withTimestamps()->withPivot('harga', 'id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getFoto($queryReturn = true)
    {
        $data = $this->hasMany(Foto::class, 'toko_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getTransaksi($queryReturn = true)
    {
        $data = $this->hasMany(Transaksi::class, 'toko_id');
        return $queryReturn ? $data : $data->get();
    }
}
