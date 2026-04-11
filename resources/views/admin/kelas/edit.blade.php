@extends('layouts.admin')
@section('title', 'Edit Kelas')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <div class="card-title">Edit Kelas</div>
        <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
    <form action="{{ route('admin.kelas.update', $kelas) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control"
                   value="{{ old('nama_kelas', $kelas->nama_kelas) }}">
            @error('nama_kelas')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Wali Kelas</label>
            <input type="text" name="wali_kelas" class="form-control"
                   value="{{ old('wali_kelas', $kelas->wali_kelas) }}">
            @error('wali_kelas')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection