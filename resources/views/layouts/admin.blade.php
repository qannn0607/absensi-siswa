<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f1f5f9; display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar { width: 250px; background: #1e3a5f; color: white; position: fixed; height: 100vh; overflow-y: auto; }
        .sidebar-brand { padding: 20px; font-size: 18px; font-weight: bold; border-bottom: 1px solid #2d5086; }
        .sidebar-brand span { color: #60a5fa; }
        .sidebar-menu { padding: 10px 0; }
        .menu-label { padding: 10px 20px; font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        .menu-item a { display: flex; align-items: center; gap: 10px; padding: 12px 20px; color: #cbd5e1; text-decoration: none; transition: all 0.2s; }
        .menu-item a:hover, .menu-item a.active { background: #2d5086; color: white; border-left: 3px solid #60a5fa; }
        .menu-item a svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* Main Content */
        .main { margin-left: 250px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { background: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
        .topbar-title { font-size: 18px; font-weight: 600; color: #1e3a5f; }
        .topbar-user { display: flex; align-items: center; gap: 10px; }
        .topbar-user span { font-size: 14px; color: #64748b; }
        .btn-logout { background: #ef4444; color: white; border: none; padding: 7px 15px; border-radius: 6px; cursor: pointer; font-size: 13px; text-decoration: none; }
        .btn-logout:hover { background: #dc2626; }

        /* Content */
        .content { padding: 25px; flex: 1; }

        /* Card */
        .card { background: white; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); padding: 20px; margin-bottom: 20px; }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9; }
        .card-title { font-size: 16px; font-weight: 600; color: #1e3a5f; }

        /* Buttons */
        .btn { padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; }
        .btn-primary { background: #1e3a5f; color: white; }
        .btn-primary:hover { background: #2d5086; }
        .btn-success { background: #22c55e; color: white; }
        .btn-success:hover { background: #16a34a; }
        .btn-warning { background: #f59e0b; color: white; }
        .btn-warning:hover { background: #d97706; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-secondary { background: #64748b; color: white; }
        .btn-secondary:hover { background: #475569; }

        /* Table */
        .table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .table th { background: #f8fafc; padding: 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 2px solid #e2e8f0; }
        .table td { padding: 12px; border-bottom: 1px solid #f1f5f9; color: #4b5563; vertical-align: middle; }
        .table tr:hover td { background: #f8fafc; }

        /* Form */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-control { width: 100%; padding: 9px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; color: #374151; transition: border 0.2s; }
        .form-control:focus { outline: none; border-color: #1e3a5f; box-shadow: 0 0 0 3px rgba(30,58,95,0.1); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }

        /* Alert */
        .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* Badge */
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-hadir { background: #dcfce7; color: #166534; }
        .badge-sakit { background: #fef9c3; color: #854d0e; }
        .badge-izin { background: #dbeafe; color: #1e40af; }
        .badge-alfa { background: #fee2e2; color: #991b1b; }

        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px; }
        .stat-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); border-left: 4px solid; }
        .stat-card.blue { border-color: #3b82f6; }
        .stat-card.green { border-color: #22c55e; }
        .stat-card.yellow { border-color: #f59e0b; }
        .stat-card.red { border-color: #ef4444; }
        .stat-label { font-size: 13px; color: #64748b; margin-bottom: 5px; }
        .stat-value { font-size: 28px; font-weight: 700; color: #1e3a5f; }

        /* Pagination */
        .pagination { display: flex; gap: 5px; margin-top: 15px; }
        .pagination a, .pagination span { padding: 6px 12px; border-radius: 5px; font-size: 13px; text-decoration: none; border: 1px solid #e2e8f0; color: #374151; }
        .pagination a:hover { background: #1e3a5f; color: white; border-color: #1e3a5f; }
        .pagination .active { background: #1e3a5f; color: white; border-color: #1e3a5f; }
    </style>
</head>
<body>

{{-- Sidebar --}}
<div class="sidebar">
    <div class="sidebar-brand">
        🏫 <span>Absensi</span> Siswa
    </div>
    <div class="sidebar-menu">
        <div class="menu-label">Menu Utama</div>
        <div class="menu-item">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
        </div>

        <div class="menu-label">Data Master</div>
        <div class="menu-item">
            <a href="{{ route('admin.kelas.index') }}" class="{{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Kelas
            </a>
        </div>
        <div class="menu-item">
            <a href="{{ route('admin.siswa.index') }}" class="{{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Siswa
            </a>
        </div>
        <div class="menu-item">
            <a href="{{ route('admin.mata-pelajaran.index') }}" class="{{ request()->routeIs('admin.mata-pelajaran.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Mata Pelajaran
            </a>
        </div>
        <div class="menu-item">
            <a href="{{ route('admin.jadwal.index') }}" class="{{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Jadwal
            </a>
        </div>

        <div class="menu-label">Absensi</div>
        <div class="menu-item">
            <a href="{{ route('admin.absensi.index') }}" class="{{ request()->routeIs('admin.absensi.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Input Absensi
            </a>
        </div>
    </div>
</div>

{{-- Main --}}
<div class="main">
    <div class="topbar">
        <div class="topbar-title">@yield('title', 'Dashboard')</div>
        <div class="topbar-user">
            <span>👤 {{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

</body>
</html>