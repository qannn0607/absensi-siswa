@extends('layouts.admin')
@section('title', 'Data Siswa')

@section('content')
<div class="p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Siswa</h1>
            <p class="text-sm text-gray-500 mt-1">Total {{ $siswa->total() }} siswa terdaftar</p>
        </div>
        <div class="flex gap-3 items-center">

            {{-- Tombol Hapus Dipilih --}}
            <form id="bulkDeleteForm" action="{{ route('admin.siswa.bulkDestroy') }}" method="POST"
                  onsubmit="return confirm('Yakin hapus siswa yang dipilih?')">
                @csrf @method('DELETE')
                <div id="bulkInputs"></div>
                <button type="submit" id="bulkDeleteBtn"
                        class="hidden items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition shadow-sm shadow-red-200">
                    🗑️ Hapus (<span id="selectedCount">0</span>)
                </button>
            </form>

            {{-- Tombol Select All --}}
            <button id="selectAllBtn" onclick="toggleSelectAll()"
                    class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition border-2 border-dashed border-gray-300 hover:border-blue-400 hover:text-blue-600 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <span id="selectAllLabel">Pilih Semua</span>
            </button>

            {{-- Import Excel --}}
            <a href="{{ route('admin.siswa.import.form') }}"
               class="flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg transition">
                📥 Import Excel
            </a>

            {{-- Tambah Siswa --}}
            <a href="{{ route('admin.siswa.create') }}"
               class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                + Tambah Siswa
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">No.</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Foto</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">NIS</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">L/P</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($siswa as $item)
                <tr class="hover:bg-blue-50/40 transition">
                    {{-- No --}}
                    <td class="px-4 py-3 text-gray-400 font-medium">{{ $loop->iteration }}</td>

                    {{-- Foto --}}
                    <td class="px-4 py-3">
                        @if($item->foto)
                            <img src="{{ Storage::url($item->foto) }}"
                                 class="w-10 h-10 rounded-full object-cover ring-2 ring-blue-100">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                    </td>

                    {{-- NIS --}}
                    <td class="px-4 py-3 font-mono text-gray-700">{{ $item->nis }}</td>

                    {{-- Nama --}}
                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $item->user->name }}</td>

                    {{-- Kelas --}}
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-full">
                            {{ $item->kelas->nama_kelas }}
                        </span>
                    </td>

                    {{-- L/P --}}
                    <td class="px-4 py-3">
                        @if($item->jenis_kelamin == 'L')
                            <span class="px-2 py-1 bg-sky-50 text-sky-600 text-xs font-medium rounded-full">Laki-laki</span>
                        @else
                            <span class="px-2 py-1 bg-pink-50 text-pink-600 text-xs font-medium rounded-full">Perempuan</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" value="{{ $item->id }}"
                                   class="checkbox-item w-4 h-4 rounded border-gray-300 text-blue-600 cursor-pointer">
                            <a href="{{ route('admin.siswa.edit', $item) }}"
                               class="px-3 py-1.5 bg-amber-400 hover:bg-amber-500 text-white text-xs font-medium rounded-lg transition">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.siswa.destroy', $item) }}" method="POST"
                                  style="display:inline" onsubmit="return confirm('Yakin hapus siswa ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-12 text-center text-gray-400">
                        <div class="flex flex-col items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6 5.87v-2a4 4 0 00-3-3.87M9 12a4 4 0 100-8 4 4 0 000 8z"/>
                            </svg>
                            <p class="text-sm">Belum ada data siswa</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
            {{ $siswa->links() }}
        </div>
    </div>
</div>

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
            bulkDeleteBtn.classList.remove('hidden');
            bulkDeleteBtn.classList.add('flex');
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
            bulkDeleteBtn.classList.add('hidden');
            bulkDeleteBtn.classList.remove('flex');
        }
    }

    function toggleSelectAll() {
        const allChecked = document.querySelectorAll('.checkbox-item:checked').length === checkboxes.length;
        checkboxes.forEach(cb => cb.checked = !allChecked);
        updateBulkBtn();

        if (!allChecked) {
            selectAllLabel.textContent = 'Batal Pilih';
            selectAllBtn.classList.add('border-blue-400', 'text-blue-600', 'bg-blue-50');
            selectAllBtn.classList.remove('border-gray-300', 'text-gray-700', 'bg-white');
        } else {
            selectAllLabel.textContent = 'Pilih Semua';
            selectAllBtn.classList.remove('border-blue-400', 'text-blue-600', 'bg-blue-50');
            selectAllBtn.classList.add('border-gray-300', 'text-gray-700', 'bg-white');
        }
    }

    // Reset tombol select all kalau ada checkbox yang di-uncheck manual
    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            updateBulkBtn();
            const checkedCount = document.querySelectorAll('.checkbox-item:checked').length;
            if (checkedCount === 0) {
                selectAllLabel.textContent = 'Pilih Semua';
                selectAllBtn.classList.remove('border-blue-400', 'text-blue-600', 'bg-blue-50');
                selectAllBtn.classList.add('border-gray-300', 'text-gray-700', 'bg-white');
            } else if (checkedCount === checkboxes.length) {
                selectAllLabel.textContent = 'Batal Pilih';
                selectAllBtn.classList.add('border-blue-400', 'text-blue-600', 'bg-blue-50');
                selectAllBtn.classList.remove('border-gray-300', 'text-gray-700', 'bg-white');
            }
        });
    });
</script>
@endsection