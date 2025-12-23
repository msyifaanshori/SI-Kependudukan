<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    protected $table = 'penduduk';
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nik',
        'no_kk',
        'id_pekerjaan',
        'id_pendidikan',
        'nama_lengkap',
        'tgl_lahir',
        'jenis_kelamin',
        'status_hidup',
        'alamat_ktp',
        'rt_ktp',
        'rw_ktp',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class, 'no_kk', 'no_kk');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'id_pekerjaan', 'id_pekerjaan');
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'id_pendidikan', 'id_pendidikan');
    }

    public function organisasi()
    {
        return $this->belongsToMany(OrganisasiMasyarakat::class, 'anggota_organisasi', 'nik', 'id_organisasi');
    }

    public function getUmurAttribute()
    {
        return $this->tgl_lahir ? $this->tgl_lahir->age : 0;
    }
}
