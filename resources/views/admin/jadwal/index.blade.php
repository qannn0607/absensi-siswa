@extends('layouts.admin')
@section('title', 'Jadwal')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Data Jadwal</div>
        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">+ Tambah Jadwal</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Hari</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jadwal as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->kelas->nama_kelas }}</td>
                <td>{{ $item->mataPelajaran->nama_mapel }}</td>
                <td>{{ $item->hari }}</td>
                <td>
                    <a href="{{ route('admin.jadwal.edit', $item) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.jadwal.destroy', $item) }}" method="POST"
                          style="display:inline" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; color:#94a3b8;">Belum ada data jadwal</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $jadwal->links() }}</div>
</div>
@endsection