<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
protected $fillable = ['nama_mapel', 'user_id'];

public function guru()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function jadwal()
{
    return $this->hasMany(Jadwal::class);
}
}
