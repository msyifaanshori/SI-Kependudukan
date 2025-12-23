<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    protected $table = 'pendidikan';
    protected $primaryKey = 'id_pendidikan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pendidikan',
        'jenjang',
    ];

    public function penduduk()
    {
        return $this->hasMany(Penduduk::class, 'id_pendidikan', 'id_pendidikan');
    }
}
