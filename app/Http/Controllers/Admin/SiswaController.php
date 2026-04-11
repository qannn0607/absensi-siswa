<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::with(['user', 'kelas'])->paginate(10);
        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'nis'           => 'required|unique:siswa,nis',
            'kelas_id'      => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'foto'          => 'nullable|image|max:2048',
        ]);

        // Buat user dulu
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto-siswa', 'public');
        }

        // Buat data siswa
        Siswa::create([
            'user_id'       => $user->id,
            'kelas_id'      => $request->kelas_id,
            'nis'           => $request->nis,
            'jenis_kelamin' => $request->jenis_kelamin,
            'foto'          => $fotoPath,
        ]);

        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|unique:users,email,' . $siswa->user_id,
            'nis'           => 'required|unique:siswa,nis,' . $siswa->id,
            'kelas_id'      => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'foto'          => 'nullable|image|max:2048',
        ]);

        // Update user
        $siswa->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->password) {
            $siswa->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $fotoPath = $request->file('foto')->store('foto-siswa', 'public');
            $siswa->foto = $fotoPath;
        }

        $siswa->update([
            'kelas_id'      => $request->kelas_id,
            'nis'           => $request->nis,
            'jenis_kelamin' => $request->jenis_kelamin,
            'foto'          => $siswa->foto,
        ]);

        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Data siswa berhasil diupdate.');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }
        $siswa->user->delete(); // cascade delete siswa juga
        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Siswa berhasil dihapus.');
    }
}
