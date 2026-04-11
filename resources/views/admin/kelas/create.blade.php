@extends('layouts.admin')
@section('title', 'Tambah Kelas')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <div class="card-title">Tambah Kelas</div>
        <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
    <form action="{{ route('admin.kelas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control"
                   value="{{ old('nama_kelas') }}" placeholder="contoh: X IPA 1">
            @error('nama_kelas')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Wali Kelas</label>
            <input type="text" name="wali_kelas" class="form-control"
                   value="{{ old('wali_kelas') }}" placeholder="contoh: Budi Santoso">
            @error('wali_kelas')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection