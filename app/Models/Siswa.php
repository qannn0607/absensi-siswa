<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
protected $fillable = ['user_id', 'kelas_id', 'nis', 'jenis_kelamin', 'foto'];

public function user()
{
    return $this->belongsTo(\App\Models\User::class, 'user_id');
}

public function kelas()
{
    return $this->belongsTo(\App\Models\Kelas::class, 'kelas_id');
}

public function absensi()
{
    return $this->hasMany(\App\Models\Absensi::class);
}
}
