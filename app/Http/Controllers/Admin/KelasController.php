<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::withCount('siswa')->paginate(10);
        return view('admin.kelas.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kelas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'nama_kelas'  => 'required|string|max:100',
            'wali_kelas'  => 'required|string|max:100',
        ]);

        Kelas::create($request->only('nama_kelas', 'wali_kelas'));

        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kela)
    {
        return view('admin.kelas.edit', ['kelas' => $kela]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'wali_kelas' => 'required|string|max:100',
        ]);

        $kela->update($request->only('nama_kelas', 'wali_kelas'));

        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Kelas berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Kelas berhasil dihapus.');
    }
}
