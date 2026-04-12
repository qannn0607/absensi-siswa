@extends('layouts.admin')
@section('title', 'Edit Mata Pelajaran')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <div class="card-title">Edit Mata Pelajaran</div>
        <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
    <form action="{{ route('admin.mata-pelajaran.update', $mapel) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Nama Mata Pelajaran</label>
            <input type="text" name="nama_mapel" class="form-control"
                   value="{{ old('nama_mapel', $mapel->nama_mapel) }}">
            @error('nama_mapel')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Guru Pengajar</label>
            <input type="text" name="guru" class="form-control"
                value="{{ old('guru', $mapel->guru) }}">
            @error('guru')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection