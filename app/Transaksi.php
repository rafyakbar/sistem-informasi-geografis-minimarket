<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'toko_id', 'created_at', 'updated_at'
    ];

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getTransaksiProduk($queryReturn = true)
    {
        $data = $this->belongsToMany(Produk::class, 'transaksi_produk', 'transaksi_id', 'produk_id')->withPivot('harga', 'jumlah');
        return $queryReturn ? $data : $data->get();
    }

    public function scopeWhereDayOfWeek($query, $field, $value)
    {
        return $query->whereRaw('extract(dow from ' . $field . ') = ' . $value);
    }

    public function scopeWhereHour($query, $field, $operator, $value)
    {
        return $query->whereRaw('extract(hour from ' . $field . ') ' . $operator . ' '. $value);
    }

}
