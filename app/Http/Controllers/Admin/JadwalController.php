<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::with(['kelas', 'mataPelajaran'])->paginate(10);
        return view('admin.jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();
        return view('admin.jadwal.create', compact('kelas', 'mapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id'          => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'hari'              => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'         => 'required',
            'jam_selesai'       => 'required|after:jam_mulai',
        ]);

        Jadwal::create($request->only(
            'kelas_id', 'mata_pelajaran_id', 'hari', 'jam_mulai', 'jam_selesai'
        ));

        return redirect()->route('admin.jadwal.index')
                         ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal)
    {
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();
        return view('admin.jadwal.edit', compact('jadwal', 'kelas', 'mapel'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'kelas_id'          => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'hari'              => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'         => 'required',
            'jam_selesai'       => 'required|after:jam_mulai',
        ]);

        $jadwal->update($request->only(
            'kelas_id', 'mata_pelajaran_id', 'hari', 'jam_mulai', 'jam_selesai'
        ));

        return redirect()->route('admin.jadwal.index')
                         ->with('success', 'Jadwal berhasil diupdate.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')
                         ->with('success', 'Jadwal berhasil dihapus.');
    }
}
