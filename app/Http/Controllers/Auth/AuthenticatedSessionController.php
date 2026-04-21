<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $loginValue = $request->username;

        // Jika input angka = login sebagai siswa pakai NIS
        if (is_numeric($loginValue)) {
            $siswa = Siswa::where('nis', $loginValue)->first();

            if (!$siswa || !$siswa->user) {
                throw ValidationException::withMessages([
                    'username' => 'NIS tidak terdaftar atau akun belum aktif.',
                ]);
            }

            if (!Hash::check($request->password, $siswa->user->password)) {
                throw ValidationException::withMessages([
                    'username' => 'Password salah.',
                ]);
            }

            Auth::login($siswa->user, $request->boolean('remember'));

        } else {
            // Login admin pakai username
            $request->authenticate();
        }

        $request->session()->regenerate();

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('siswa.dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}