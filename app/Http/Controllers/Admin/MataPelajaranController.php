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
        return view('admin.mata-pelajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:100',
        ]);

        MataPelajaran::create([
            'nama_mapel' => $request->nama_mapel,
            'user_id'    => $request->user()->id,
        ]);

        return redirect()->route('admin.mata-pelajaran.index')
                         ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(MataPelajaran $mata_pelajaran)
    {
        return view('admin.mata-pelajaran.edit', ['mapel' => $mata_pelajaran]);
    }

    public function update(Request $request, MataPelajaran $mata_pelajaran)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:100',
        ]);

        $mata_pelajaran->update([
            'nama_mapel' => $request->nama_mapel,
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
