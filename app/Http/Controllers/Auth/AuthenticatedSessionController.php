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
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Cek apakah input adalah NIS (angka) atau email
        $loginField = is_numeric($request->email) ? 'nis' : 'email';

        if ($loginField === 'nis') {
            // Cari siswa berdasarkan NIS
            $siswa = Siswa::where('nis', $request->email)->first();

            // Cek apakah siswa ditemukan
            if (!$siswa) {
                throw ValidationException::withMessages([
                    'email' => 'NIS tidak ditemukan.',
                ]);
            }

            // Cek apakah siswa punya akun user
            if (!$siswa->user) {
                throw ValidationException::withMessages([
                    'email' => 'Akun untuk siswa ini tidak ditemukan.',
                ]);
            }

            // Cek password
            if (!Hash::check($request->password, $siswa->user->password)) {
                throw ValidationException::withMessages([
                    'email' => 'NIS atau password salah.',
                ]);
            }

            // Login user
            Auth::login($siswa->user, $request->boolean('remember'));

        } else {
            // Login pakai email biasa
            $request->authenticate();
        }

        // Regenerate session
        $request->session()->regenerate();

        // Redirect berdasarkan role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('siswa.dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}