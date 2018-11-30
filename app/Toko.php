<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

    /**
     * Menampilkan daftar ringkasan jumlah transaksi dari hari minggu sampai sabtu
     * Jika jenis adalah jam, maka akan ditampilkan jumlah transaksi per hari dengan
     * jumlah transaksi per janya dari jam 7 sampai jam 10 malam
     *
     * @param string $jenis
     * @return array
     */
    public function getRingkasanTransaksi($jenis = 'harijam')
    {
        $daftarTransaksi = $this->getTransaksi();
        $start = Carbon::parse((clone $daftarTransaksi)->orderBy('created_at')->first()->created_at);
        $end = Carbon::parse((clone $daftarTransaksi)->orderBy('created_at', 'DESC')->first()->created_at);
        $selisihHari = $start->diffInDays($end);
        $selisihMinggu = $start->diffInWeeks($end);
        $ringkasan = [];

        if ($jenis == 'jam') {
            for ($jam = 7; $jam <= 20; $jam++) {
                $ringkasan[$jam] = ceil((clone $daftarTransaksi)->whereHour('created_at', '=', $jam)->count() / $selisihHari);
            }
        }
        else if($jenis == 'hari') {
            for ($i = 0; $i <= 6; $i++) {
                $ringkasan[$i] = ceil((clone $daftarTransaksi)->whereDayOfWeek('created_at', $i)->count() / $selisihMinggu);
            }
        }
        else {
            for ($i = 0; $i <= 6; $i++) {
                for ($jam = 7; $jam <= 20; $jam++) {
                    $ringkasan[$i][$jam] = ceil((clone $daftarTransaksi)->whereDayOfWeek('created_at', $i)->whereHour('created_at', '=', $jam)->count() / $selisihMinggu);
                }
            }
        }

        return $ringkasan;
    }

}
