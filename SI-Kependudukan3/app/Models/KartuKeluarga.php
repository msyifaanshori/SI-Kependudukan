<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    protected $table = 'kartu_keluarga';
    protected $primaryKey = 'no_kk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_kk',
        'kepala_keluarga_nik',
        'alamat',
        'rt',
        'rw',
    ];

    public function kepalaKeluarga()
    {
        return $this->belongsTo(Penduduk::class, 'kepala_keluarga_nik', 'nik');
    }

    public function anggotaKeluarga()
    {
        return $this->hasMany(Penduduk::class, 'no_kk', 'no_kk');
    }
}
