@extends('layouts.admin')
@section('title', 'Input Absensi')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Input Absensi</div>
        <a href="{{ route('admin.absensi.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    @if(!$tahunAjaran)
        <div class="alert alert-danger">
            ⚠️ Belum ada tahun ajaran aktif. Silakan tambahkan tahun ajaran terlebih dahulu.
        </div>
    @else
    <form action="{{ route('admin.absensi.store') }}" method="POST" id="formAbsensi">
        @csrf
        <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaran->id }}">

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control"
                       value="{{ old('tanggal', date('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Jadwal / Mata Pelajaran</label>
                <select name="jadwal_id" class="form-control" id="jadwalSelect" required>
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach($jadwal as $j)
                        <option value="{{ $j->id }}"
                                data-kelas="{{ $j->kelas_id }}"
                                {{ old('jadwal_id') == $j->id ? 'selected' : '' }}>
                            {{ $j->kelas->nama_kelas }} - {{ $j->mataPelajaran->nama_mapel }}
                            ({{ $j->hari }}, {{ $j->jam_mulai }}-{{ $j->jam_selesai }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="tabelAbsensi" style="display:none; margin-top:15px;">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody id="siswaTbody"></tbody>
            </table>
            <button type="submit" class="btn btn-primary" style="margin-top:10px;">
                💾 Simpan Absensi
            </button>
        </div>
    </form>

    {{-- Data siswa per kelas (hidden, dipakai JS) --}}
    @foreach($jadwal as $j)
        <div id="siswa-kelas-{{ $j->id }}" style="display:none"
             data-siswa='@json($j->kelas->siswa->map(fn($s) => ["id" => $s->id, "nis" => $s->nis, "nama" => $s->user->name ?? "-"]))'>
        </div>
    @endforeach

    <script>
    document.getElementById('jadwalSelect').addEventListener('change', function () {
        const jadwalId = this.value;
        const tbody    = document.getElementById('siswaTbody');
        const tabel    = document.getElementById('tabelAbsensi');

        if (!jadwalId) { tabel.style.display = 'none'; return; }

        const dataEl = document.getElementById('siswa-kelas-' + jadwalId);
        if (!dataEl) { tabel.style.display = 'none'; return; }

        const siswaList = JSON.parse(dataEl.dataset.siswa);
        tbody.innerHTML = '';

        if (siswaList.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;color:#94a3b8;">Tidak ada siswa di kelas ini</td></tr>';
        } else {
            siswaList.forEach((siswa, i) => {
                tbody.innerHTML += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${siswa.nis}</td>
                    <td>${siswa.nama}</td>
                    <td>
                        <select name="absensi[${siswa.id}][status]" class="form-control" style="width:120px" required>
                            <option value="hadir">Hadir</option>
                            <option value="sakit">Sakit</option>
                            <option value="izin">Izin</option>
                            <option value="alfa">Alfa</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="absensi[${siswa.id}][keterangan]"
                               class="form-control" placeholder="Keterangan (opsional)">
                    </td>
                </tr>`;
            });
        }

        tabel.style.display = 'block';
    });
    </script>
    @endif
</div>
@endsection