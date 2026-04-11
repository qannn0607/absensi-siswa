@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-label">Total Siswa</div>
        <div class="stat-value">{{ $totalSiswa }}</div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">Total Kelas</div>
        <div class="stat-value">{{ $totalKelas }}</div>
    </div>
    <div class="stat-card yellow">
        <div class="stat-label">Hadir Hari Ini</div>
        <div class="stat-value">{{ $hadirHariIni }}</div>
    </div>
    <div class="stat-card red">
        <div class="stat-label">Alfa Hari Ini</div>
        <div class="stat-value">{{ $alfaHariIni }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Absensi Hari Ini</div>
        <a href="{{ route('admin.absensi.create') }}" class="btn btn-primary">+ Input Absensi</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $absensiHariIni = \App\Models\Absensi::with(['siswa.user', 'siswa.kelas'])
                    ->whereDate('tanggal', today())->latest()->take(10)->get();
            @endphp
            @forelse($absensiHariIni as $abs)
            <tr>
                <td>{{ $abs->siswa->user->name }}</td>
                <td>{{ $abs->siswa->kelas->nama_kelas }}</td>
                <td><span class="badge badge-{{ $abs->status }}">{{ ucfirst($abs->status) }}</span></td>
                <td>{{ $abs->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center; color:#94a3b8;">Belum ada absensi hari ini</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection