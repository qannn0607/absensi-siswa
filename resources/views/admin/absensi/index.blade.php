@extends('layouts.admin')
@section('title', 'Data Absensi')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Data Absensi</div>
        <a href="{{ route('admin.absensi.create') }}" class="btn btn-primary">+ Input Absensi</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensi as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $item->siswa->user->name }}</td>
                <td>{{ $item->siswa->kelas->nama_kelas }}</td>
                <td>{{ $item->jadwal->mataPelajaran->nama_mapel }}</td>
                <td><span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                <td>{{ $item->keterangan ?? '-' }}</td>
                <td>
                    <form action="{{ route('admin.absensi.destroy', $item) }}" method="POST"
                          style="display:inline" onsubmit="return confirm('Yakin hapus data ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; color:#94a3b8;">Belum ada data absensi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $absensi->links() }}</div>
</div>
@endsection