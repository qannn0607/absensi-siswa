<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use id;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapel = MataPelajaran::with('guru')->paginate(10);
        return view('admin.mata-pelajaran.index', compact('mapel'));
    }

    public function create()
{
    $guru = \App\Models\User::where('role', 'admin')->get(); // admin = guru
    return view('admin.mata-pelajaran.create', compact('guru'));
}

public function store(Request $request)
{
    $request->validate([
        'nama_mapel' => 'required|string|max:100',
        'guru'    => 'required|string|max:100',
    ]);

    MataPelajaran::create([
        'nama_mapel' => $request->nama_mapel,
        'guru'    => $request->guru,
    ]);

    return redirect()->route('admin.mata-pelajaran.index')
                     ->with('success', 'Mata pelajaran berhasil ditambahkan.');
}

public function edit(MataPelajaran $mata_pelajaran)
{
    $guru = \App\Models\User::where('role', 'admin')->get();
    return view('admin.mata-pelajaran.edit', ['mapel' => $mata_pelajaran, 'guru' => $guru]);
}

public function update(Request $request, MataPelajaran $mata_pelajaran)
{
    $request->validate([
        'nama_mapel' => 'required|string|max:100',
        'user_id'    => 'required|exists:users,id',
    ]);

    $mata_pelajaran->update([
        'nama_mapel' => $request->nama_mapel,
        'guru'    => $request->guru,
    ]);

    return redirect()->route('admin.mata-pelajaran.index')
                     ->with('success', 'Mata pelajaran berhasil diupdate.');
}

    public function destroy(MataPelajaran $mata_pelajaran)
    {
        $mata_pelajaran->delete();
        return redirect()->route('admin.mata-pelajaran.index')
                         ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
