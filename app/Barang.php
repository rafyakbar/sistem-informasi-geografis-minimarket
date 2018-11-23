<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'kategori_id', 'nama'
    ];

    public function getKategori($queryReturn = true)
    {
        $data = $this->belongsTo(Kategori::class, 'kategori_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getToko($queryReturn = true)
    {
        $data = $this->belongsToMany(Toko::class, 'produk', 'barang_id', 'toko_id')->withTimestamps()->withPivot('harga');
        return $queryReturn ? $data : $data->get();
    }


}
