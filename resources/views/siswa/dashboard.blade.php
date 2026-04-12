<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
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

        .welcome-card { background: linear-gradient(135deg, #1e3a5f, #2d5086); color: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; }
        .welcome-card h2 { font-size: 22px; margin-bottom: 5px; }
        .welcome-card p { font-size: 14px; color: #94a3b8; }
        .welcome-card .info { display: flex; gap: 20px; margin-top: 15px; font-size: 13px; }
        .welcome-card .info span { background: rgba(255,255,255,0.1); padding: 5px 12px; border-radius: 20px; }

        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px; }
        .stat-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); border-left: 4px solid; text-align: center; }
        .stat-card.green { border-color: #22c55e; }
        .stat-card.yellow { border-color: #f59e0b; }
        .stat-card.blue { border-color: #3b82f6; }
        .stat-card.red { border-color: #ef4444; }
        .stat-label { font-size: 13px; color: #64748b; margin-bottom: 5px; }
        .stat-value { font-size: 30px; font-weight: 700; color: #1e3a5f; }

        .card { background: white; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); padding: 20px; margin-bottom: 20px; }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9; }
        .card-title { font-size: 16px; font-weight: 600; color: #1e3a5f; }

        .progress-bar { background: #e2e8f0; border-radius: 10px; height: 12px; margin-top: 10px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 10px; background: linear-gradient(90deg, #22c55e, #16a34a); transition: width 1s ease; }

        .table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .table th { background: #f8fafc; padding: 10px 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 2px solid #e2e8f0; }
        .table td { padding: 10px 12px; border-bottom: 1px solid #f1f5f9; color: #4b5563; }

        .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-hadir { background: #dcfce7; color: #166534; }
        .badge-sakit { background: #fef9c3; color: #854d0e; }
        .badge-izin { background: #dbeafe; color: #1e40af; }
        .badge-alfa { background: #fee2e2; color: #991b1b; }

        .btn { padding: 7px 14px; border-radius: 6px; border: none; cursor: pointer; font-size: 13px; text-decoration: none; }
        .btn-primary { background: #1e3a5f; color: white; }
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
    <div class="welcome-card">
        <h2>Halo, {{ Auth::user()->name }}! 👋</h2>
        <p>Berikut rekap kehadiran kamu</p>
        <div class="info">
            <span>📋 NIS: {{ $siswa->nis }}</span>
            <span>🏫 Kelas: {{ $siswa->kelas->nama_kelas }}</span>
            <span>{{ $siswa->jenis_kelamin == 'L' ? '👦 Laki-laki' : '👧 Perempuan' }}</span>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card green">
            <div class="stat-label">Hadir</div>
            <div class="stat-value">{{ $totalHadir }}</div>
        </div>
        <div class="stat-card yellow">
            <div class="stat-label">Sakit</div>
            <div class="stat-value">{{ $totalSakit }}</div>
        </div>
        <div class="stat-card blue">
            <div class="stat-label">Izin</div>
            <div class="stat-value">{{ $totalIzin }}</div>
        </div>
        <div class="stat-card red">
            <div class="stat-label">Alfa</div>
            <div class="stat-value">{{ $totalAlfa }}</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Persentase Kehadiran</div>
            <span style="font-size:20px; font-weight:700; color:#22c55e">{{ $persentase }}%</span>
        </div>
        <div class="progress-bar">
            <div class="progress-fill" style="width: {{ $persentase }}%"></div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Absensi Terbaru</div>
            <a href="{{ route('siswa.rekap') }}" class="btn btn-primary">Lihat Semua</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Mata Pelajaran</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensiTerbaru as $abs)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($abs->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $abs->jadwal->mataPelajaran->nama_mapel }}</td>
                    <td><span class="badge badge-{{ $abs->status }}">{{ ucfirst($abs->status) }}</span></td>
                    <td>{{ $abs->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:#94a3b8;">Belum ada data absensi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>