@extends('layouts.admin')
@section('title', 'Data Absensi')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Data Absensi</div>
        <div style="display:flex; gap:8px; align-items:center;">

            {{-- Tombol Hapus Dipilih --}}
            <form id="bulkDeleteForm" action="{{ route('admin.absensi.bulkDestroy') }}" method="POST"
                  onsubmit="return confirm('Yakin hapus absensi yang dipilih?')">
                @csrf @method('DELETE')
                <div id="bulkInputs"></div>
                <button type="submit" id="bulkDeleteBtn"
                        style="display:none; align-items:center; gap:6px; padding:8px 16px; background:#ef4444; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px;">
                    🗑️ Hapus (<span id="selectedCount">0</span>)
                </button>
            </form>

            {{-- Tombol Pilih Semua --}}
            <button id="selectAllBtn" onclick="toggleSelectAll()"
                    style="display:flex; align-items:center; gap:6px; padding:8px 16px; background:white; color:#374151; border:2px dashed #d1d5db; border-radius:6px; cursor:pointer; font-size:13px; transition:all 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:15px;height:15px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <span id="selectAllLabel">Pilih Semua</span>
            </button>

            <a href="{{ route('admin.absensi.create') }}" class="btn btn-primary">+ Input Absensi</a>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
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
                    <div style="display:flex; align-items:center; gap:8px;">
                        <input type="checkbox" value="{{ $item->id }}"
                               class="checkbox-item"
                               style="width:16px; height:16px; cursor:pointer; accent-color:#1e3a5f;">
                        <form action="{{ route('admin.absensi.destroy', $item) }}" method="POST"
                              style="display:inline" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; color:#94a3b8; padding:40px;">
                    Belum ada data absensi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:16px; padding-top:16px; border-top:1px solid #f1f5f9;">
        <span style="font-size:13px; color:#64748b;">
            Menampilkan {{ $absensi->firstItem() ?? 0 }} - {{ $absensi->lastItem() ?? 0 }}
            dari {{ $absensi->total() }} data
        </span>
        <div>{{ $absensi->links() }}</div>
    </div>
</div>

<style>
    /* Pagination fix */
    nav[role="navigation"] > div:first-child { display: none; }
    nav[role="navigation"] > div:last-child {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    nav[role="navigation"] span[aria-current="page"] > span {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        background: #1e3a5f;
        color: white;
        border: 1px solid #1e3a5f;
        display: inline-block;
    }
    nav[role="navigation"] span > span {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        background: #f8fafc;
        color: #94a3b8;
        border: 1px solid #e2e8f0;
        display: inline-block;
    }
    nav[role="navigation"] a {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        text-decoration: none;
        border: 1px solid #e2e8f0;
        color: #374151;
        background: white;
        display: inline-block;
        transition: all 0.2s;
    }
    nav[role="navigation"] a:hover {
        background: #1e3a5f;
        color: white;
        border-color: #1e3a5f;
    }
    #bulkDeleteBtn:hover {
        background: #dc2626 !important;
    }
</style>

<script>
    const checkboxes = document.querySelectorAll('.checkbox-item');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const selectAllLabel = document.getElementById('selectAllLabel');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const selectedCount = document.getElementById('selectedCount');
    const bulkInputs = document.getElementById('bulkInputs');

    function updateBulkBtn() {
        const checked = document.querySelectorAll('.checkbox-item:checked');
        const count = checked.length;

        if (count > 0) {
            bulkDeleteBtn.style.display = 'inline-flex';
            selectedCount.textContent = count;

            bulkInputs.innerHTML = '';
            checked.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                bulkInputs.appendChild(input);
            });
        } else {
            bulkDeleteBtn.style.display = 'none';
        }
    }

    function toggleSelectAll() {
        const allChecked = document.querySelectorAll('.checkbox-item:checked').length === checkboxes.length;
        checkboxes.forEach(cb => cb.checked = !allChecked);
        updateBulkBtn();

        if (!allChecked) {
            selectAllLabel.textContent = 'Batal Pilih';
            selectAllBtn.style.borderColor = '#3b82f6';
            selectAllBtn.style.color = '#1d4ed8';
            selectAllBtn.style.background = '#eff6ff';
        } else {
            selectAllLabel.textContent = 'Pilih Semua';
            selectAllBtn.style.borderColor = '#d1d5db';
            selectAllBtn.style.color = '#374151';
            selectAllBtn.style.background = 'white';
        }
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            updateBulkBtn();
            const checkedCount = document.querySelectorAll('.checkbox-item:checked').length;
            if (checkedCount === 0) {
                selectAllLabel.textContent = 'Pilih Semua';
                selectAllBtn.style.borderColor = '#d1d5db';
                selectAllBtn.style.color = '#374151';
                selectAllBtn.style.background = 'white';
            } else if (checkedCount === checkboxes.length) {
                selectAllLabel.textContent = 'Batal Pilih';
                selectAllBtn.style.borderColor = '#3b82f6';
                selectAllBtn.style.color = '#1d4ed8';
                selectAllBtn.style.background = '#eff6ff';
            }
        });
    });
</script>
@endsection