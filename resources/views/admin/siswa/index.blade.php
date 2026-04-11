@extends('layouts.admin')
@section('title', 'Data Siswa')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Data Siswa</div>
        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">+ Tambah Siswa</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Foto</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>L/P</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($item->foto)
                        <img src="{{ Storage::url($item->foto) }}"
                             style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                    @else
                        <div style="width:40px;height:40px;border-radius:50%;background:#e2e8f0;display:flex;align-items:center;justify-content:center;font-size:18px;">👤</div>
                    @endif
                </td>
                <td>{{ $item->nis }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->kelas->nama_kelas }}</td>
                <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $item->user->email }}</td>
                <td>
                    <a href="{{ route('admin.siswa.edit', $item) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.siswa.destroy', $item) }}" method="POST"
                          style="display:inline" onsubmit="return confirm('Yakin hapus siswa ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; color:#94a3b8;">Belum ada data siswa</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $siswa->links() }}</div>
</div>
@endsection