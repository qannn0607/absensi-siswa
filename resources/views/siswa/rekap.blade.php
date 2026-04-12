<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f1f5f9; min-height: 100vh; }
        .topbar { background: #1e3a5f; color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; }
        .topbar-brand { font-size: 18px; font-weight: bold; }
        .topbar-brand span { color: #60a5fa; }
        .topbar-user { display: flex; align-items: center; gap: 15px; font-size: 14px; }
        .btn-logout { background: #ef4444; color: white; border: none; padding: 7px 15px; border-radius: 6px; cursor: pointer; font-size: 13px; text-decoration: none; }
        .content { padding: 25px; max-width: 900px; margin: 0 auto; }
        .card { background: white; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); padding: 20px; }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9; }
        .card-title { font-size: 16px; font-weight: 600; color: #1e3a5f; }
        .btn { padding: 7px 14px; border-radius: 6px; border: none; cursor: pointer; font-size: 13px; text-decoration: none; }
        .btn-secondary { background: #64748b; color: white; }
        .table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .table th { background: #f8fafc; padding: 10px 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 2px solid #e2e8f0; }
        .table td { padding: 10px 12px; border-bottom: 1px solid #f1f5f9; color: #4b5563; }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-hadir { background: #dcfce7; color: #166534; }
        .badge-sakit { background: #fef9c3; color: #854d0e; }
        .badge-izin { background: #dbeafe; color: #1e40af; }
        .badge-alfa { background: #fee2e2; color: #991b1b; }
        .pagination { display: flex; gap: 5px; margin-top: 15px; }
        .pagination a, .pagination span { padding: 6px 12px; border-radius: 5px; font-size: 13px; text-decoration: none; border: 1px solid #e2e8f0; color: #374151; }
        .pagination a:hover { background: #1e3a5f; color: white; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-brand">🏫 <span>Absensi</span> Siswa</div>
    <div class="topbar-user">
        <span>👤 {{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Rekap Absensi — {{ Auth::user()->name }}</div>
            <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">← Kembali</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Mata Pelajaran</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $abs)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($abs->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $abs->jadwal->mataPelajaran->nama_mapel }}</td>
                    <td><span class="badge badge-{{ $abs->status }}">{{ ucfirst($abs->status) }}</span></td>
                    <td>{{ $abs->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; color:#94a3b8;">Belum ada data absensi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $absensi->links() }}</div>
    </div>
</div>

</body>
</html>