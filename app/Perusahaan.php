<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = 'perusahaan';

    protected $fillable = [
        'nama'
    ];

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getToko($queryReturn = true)
    {
        $data = $this->hasMany(Toko::class, 'perusahaan_id');
        return $queryReturn ? $data : $data->get();
    }
}
