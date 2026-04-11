<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        
        $hadirHariIni = Absensi::where('tanggal', now()->format('Y-m-d'))
                                ->where('status', 'hadir')
                                ->count();
                                
        $alfaHariIni = Absensi::where('tanggal', now()->format('Y-m-d'))
                                ->where('status', 'alfa')
                                ->count();

        $absensi = \App\Models\Absensi::with(['siswa', 'jadwal'])->latest()->get();
        return view('admin.dashboard', compact(
            'totalSiswa', 
            'totalKelas', 
            'hadirHariIni', 
            'alfaHariIni'
        ));
    }
}
