<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $fillable = [
        'nama'
    ];

    /**
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|null|object
     */
    public function getBarang($queryReturn = true)
    {
        $data = $this->hasMany(Barang::class, 'kategori_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param $name
     * @return bool
     */
    public static function check($name)
    {
        return Kategori::query()
            ->where('nama', $name)
            ->count() > 0;
    }
}
