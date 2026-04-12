@extends('layouts.admin')
@section('title', 'Tambah Jadwal')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <div class="card-title">Tambah Jadwal</div>
        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
    <form action="{{ route('admin.jadwal.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-control">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
            @error('kelas_id')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Mata Pelajaran</label>
            <select name="mata_pelajaran_id" class="form-control">
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach($mapel as $m)
                    <option value="{{ $m->id }}" {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>
                        {{ $m->nama_mapel }}
                    </option>
                @endforeach
            </select>
            @error('mata_pelajaran_id')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Hari</label>
            <select name="hari" class="form-control">
                <option value="">-- Pilih Hari --</option>
                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                    <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>
                        {{ $hari }}
                    </option>
                @endforeach
            </select>
            @error('hari')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection