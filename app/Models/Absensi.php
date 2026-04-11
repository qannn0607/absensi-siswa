<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
protected $fillable = ['siswa_id', 'jadwal_id', 'tahun_ajaran_id', 'tanggal', 'status', 'keterangan'];

public function siswa()
{
    return $this->belongsTo(Siswa::class);
}

public function jadwal()
{
    return $this->belongsTo(Jadwal::class);
}

public function tahunAjaran()
{
    return $this->belongsTo(TahunAjaran::class);
}
}
