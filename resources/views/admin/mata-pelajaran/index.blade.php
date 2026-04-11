@extends('layouts.admin')
@section('title', 'Mata Pelajaran')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Data Mata Pelajaran</div>
        <a href="{{ route('admin.mata-pelajaran.create') }}" class="btn btn-primary">+ Tambah Mapel</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Mata Pelajaran</th>
                <th>Guru</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mapel as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_mapel }}</td>
                <td>{{ $item->guru->name ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.mata-pelajaran.edit', $item) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.mata-pelajaran.destroy', $item) }}" method="POST"
                          style="display:inline" onsubmit="return confirm('Yakin hapus mapel ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; color:#94a3b8;">Belum ada data mata pelajaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $mapel->links() }}</div>
</div>
@endsection