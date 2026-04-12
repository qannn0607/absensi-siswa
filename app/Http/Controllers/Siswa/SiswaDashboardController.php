<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
        public function index()
    {
        $siswa = Auth::user()->siswa;

        $totalHadir = Absensi::where('siswa_id', $siswa->id)
                              ->where('status', 'hadir')->count();
        $totalSakit = Absensi::where('siswa_id', $siswa->id)
                              ->where('status', 'sakit')->count();
        $totalIzin  = Absensi::where('siswa_id', $siswa->id)
                              ->where('status', 'izin')->count();
        $totalAlfa  = Absensi::where('siswa_id', $siswa->id)
                              ->where('status', 'alfa')->count();
        $total      = $totalHadir + $totalSakit + $totalIzin + $totalAlfa;
        $persentase = $total > 0 ? round(($totalHadir / $total) * 100) : 0;

        $absensiTerbaru = Absensi::with('jadwal.mataPelajaran')
                                 ->where('siswa_id', $siswa->id)
                                 ->latest()->take(5)->get();

        return view('siswa.dashboard', compact(
            'siswa', 'totalHadir', 'totalSakit', 'totalIzin',
            'totalAlfa', 'persentase', 'absensiTerbaru'
        ));
    }

    public function rekap()
    {
        $siswa   = Auth::user()->siswa;
        $absensi = Absensi::with('jadwal.mataPelajaran')
                          ->where('siswa_id', $siswa->id)
                          ->latest()->paginate(15);

        return view('siswa.rekap', compact('siswa', 'absensi'));
    }
}
