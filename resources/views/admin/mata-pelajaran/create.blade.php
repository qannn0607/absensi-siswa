@extends('layouts.admin')
@section('title', 'Tambah Mata Pelajaran')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <div class="card-title">Tambah Mata Pelajaran</div>
        <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
    <form action="{{ route('admin.mata-pelajaran.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Nama Mata Pelajaran</label>
            <input type="text" name="nama_mapel" class="form-control"
                   value="{{ old('nama_mapel') }}" placeholder="contoh: Matematika">
            @error('nama_mapel')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Guru Pengajar</label>
            <input type="text" name="guru" class="form-control"
                value="{{ old('guru') }}" placeholder="contoh: Budi Santoso">
            @error('guru')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection