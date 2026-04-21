@extends('layouts.admin')
@section('title', 'Tambah Siswa')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <div class="card-title">Tambah Siswa</div>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
    <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name') }}" placeholder="Nama siswa">
                @error('name')<small style="color:red">{{ $message }}</small>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control"
                       value="{{ old('nis') }}" placeholder="Nomor Induk Siswa">
                @error('nis')<small style="color:red">{{ $message }}</small>@enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control"
                       placeholder="Minimal 6 karakter">
                @error('password')<small style="color:red">{{ $message }}</small>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')<small style="color:red">{{ $message }}</small>@enderror
            </div>
        </div>
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
            <label class="form-label">Foto (opsional)</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            @error('foto')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection