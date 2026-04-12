<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::with(['siswa.user', 'siswa.kelas', 'jadwal.mataPelajaran'])
                          ->latest()->paginate(15);
        return view('admin.absensi.index', compact('absensi'));
    }

    public function create()
    {
        $kelas        = Kelas::all();
        $jadwal       = Jadwal::with(['kelas', 'mataPelajaran'])->get();
        $tahunAjaran  = TahunAjaran::where('is_aktif', true)->first();
        return view('admin.absensi.create', compact('kelas', 'jadwal', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id'      => 'required|exists:jadwal,id',
            'tanggal'        => 'required|date',
            'tahun_ajaran_id'=> 'required|exists:tahun_ajaran,id',
            'absensi'        => 'required|array',
            'absensi.*.status' => 'required|in:hadir,sakit,izin,alfa',
        ]);

        foreach ($request->absensi as $siswaId => $data) {
            Absensi::updateOrCreate(
                [
                    'siswa_id'  => $siswaId,
                    'jadwal_id' => $request->jadwal_id,
                    'tanggal'   => $request->tanggal,
                ],
                [
                    'tahun_ajaran_id' => $request->tahun_ajaran_id,
                    'status'          => $data['status'],
                    'keterangan'      => $data['keterangan'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.absensi.index')
                         ->with('success', 'Absensi berhasil disimpan.');
    }

    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return redirect()->route('admin.absensi.index')
                         ->with('success', 'Data absensi berhasil dihapus.');
    }
    
    public function bulkDestroy(Request $request)
{
    $ids = $request->input('ids', []);

    if (empty($ids)) {
        return back()->with('error', 'Tidak ada data yang dipilih.');
    }

    Absensi::whereIn('id', $ids)->delete();

    return back()->with('success', count($ids) . ' data absensi berhasil dihapus.');
}
}
