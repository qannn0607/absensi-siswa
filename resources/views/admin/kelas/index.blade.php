@extends('layouts.admin')
@section('title', 'Data Kelas')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Data Kelas</div>
        <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary">+ Tambah Kelas</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Kelas</th>
                <th>Wali Kelas</th>
                <th>Jumlah Siswa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kelas as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_kelas }}</td>
                <td>{{ $item->wali_kelas }}</td>
                <td>{{ $item->siswa_count }} siswa</td>
                <td>
                    <a href="{{ route('admin.kelas.edit', $item) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.kelas.destroy', $item) }}" method="POST" style="display:inline"
                          onsubmit="return confirm('Yakin hapus kelas ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; color:#94a3b8;">Belum ada data kelas</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $kelas->links() }}</div>
</div>
@endsection