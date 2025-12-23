<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganisasiMasyarakat extends Model
{
    protected $table = 'organisasi_masyarakat';
    protected $primaryKey = 'id_organisasi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_organisasi',
        'nama_organisasi',
    ];

    public function anggota()
    {
        return $this->belongsToMany(Penduduk::class, 'anggota_organisasi', 'id_organisasi', 'nik');
    }
}
