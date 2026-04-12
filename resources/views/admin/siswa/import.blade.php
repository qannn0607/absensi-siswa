@extends('layouts.admin')
@section('title', 'Import Siswa')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <div class="card-title">Import Data Siswa</div>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    {{-- Info kolom --}}
    <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:15px; margin-bottom:20px;">
        <p style="font-weight:600; color:#1e40af; margin-bottom:8px;">📋 Pastikan file Excel kamu memiliki kolom berikut:</p>
        <div style="display:flex; flex-wrap:wrap; gap:8px;">
            @foreach(['nama','nis','email','password','kelas','jenis_kelamin'] as $col)
            <span style="background:#dbeafe; color:#1e40af; padding:4px 12px; border-radius:20px; font-size:13px; font-weight:600;">
                {{ $col }}
            </span>
            @endforeach
        </div>
        <p style="font-size:12px; color:#64748b; margin-top:10px;">
            * Kolom <strong>kelas</strong> harus sesuai nama kelas yang ada di sistem<br>
            * Kolom <strong>jenis_kelamin</strong>: isi <strong>L</strong> atau <strong>P</strong><br>
            * Kolom <strong>password</strong> opsional, default: <strong>12345678</strong><br>
            * NIS dan email yang sudah ada akan dilewati otomatis
        </p>
    </div>

    {{-- Form Upload --}}
    <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label">Pilih File Excel</label>
            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
            @error('file')<small style="color:red">{{ $message }}</small>@enderror
        </div>
        <button type="submit" class="btn btn-primary">📤 Import Sekarang</button>
    </form>
</div>
@endsection