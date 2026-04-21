@extends('layouts.admin')
@section('title', 'Edit Siswa')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <div class="card-title">Edit Siswa</div>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
    <form action="{{ route('admin.siswa.update', $siswa) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $siswa->user->name) }}">
                @error('name')<small style="color:red">{{ $message }}</small>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control"
                       value="{{ old('nis', $siswa->nis) }}">
                @error('nis')<small style="color:red">{{ $message }}</small>@enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Password Baru <small style="color:#94a3b8">(kosongkan jika tidak diubah)</small></label>
                <input type="password" name="password" class="form-control"
                       placeholder="Isi jika ingin ganti password">
            </div>
            <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-control">
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}"
                        {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
            @error('kelas_id')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Foto</label>
            @if($siswa->foto)
                <div style="margin-bottom:8px">
                    <img src="{{ Storage::url($siswa->foto) }}"
                         style="width:60px;height:60px;border-radius:50%;object-fit:cover;">
                </div>
            @endif
            <input type="file" name="foto" class="form-control" accept="image/*">
            @error('foto')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection