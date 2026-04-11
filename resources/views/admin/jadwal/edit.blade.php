@extends('layouts.admin')
@section('title', 'Edit Jadwal')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <div class="card-title">Edit Jadwal</div>
        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
    <form action="{{ route('admin.jadwal.update', $jadwal) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-control">
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}"
                        {{ old('kelas_id', $jadwal->kelas_id) == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Mata Pelajaran</label>
            <select name="mata_pelajaran_id" class="form-control">
                @foreach($mapel as $m)
                    <option value="{{ $m->id }}"
                        {{ old('mata_pelajaran_id', $jadwal->mata_pelajaran_id) == $m->id ? 'selected' : '' }}>
                        {{ $m->nama_mapel }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Hari</label>
            <select name="hari" class="form-control">
                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                    <option value="{{ $hari }}"
                        {{ old('hari', $jadwal->hari) == $hari ? 'selected' : '' }}>
                        {{ $hari }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Jam Mulai</label>
                <input type="time" name="jam_mulai" class="form-control"
                       value="{{ old('jam_mulai', $jadwal->jam_mulai) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Jam Selesai</label>
                <input type="time" name="jam_selesai" class="form-control"
                       value="{{ old('jam_selesai', $jadwal->jam_selesai) }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection