<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'foto';

    protected $fillable = [
        'toko_id', 'dir'
    ];

    /**
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getToko($queryReturn = true)
    {
        $data = $this->belongsTo(Toko::class, 'toko_id');
        return $queryReturn ? $data : $data->first();
    }
}
