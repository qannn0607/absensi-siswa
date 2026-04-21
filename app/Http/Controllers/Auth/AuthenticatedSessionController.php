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
    // Kita cek apakah inputnya angka (NIS) atau teks (Username)
    // Ingat: ganti $request->email jadi $request->username sesuai input di form nanti
    $loginValue = $request->username ?? $request->email; 
    $loginField = is_numeric($loginValue) ? 'nis' : 'username';

    if ($loginField === 'nis') {
        // Logika untuk Siswa via NIS
        $siswa = Siswa::where('nis', $loginValue)->first();

        if (!$siswa || !$siswa->user) {
            throw ValidationException::withMessages([
                'username' => 'NIS atau akun tidak ditemukan.',
            ]);
        }

        if (!Hash::check($request->password, $siswa->user->password)) {
            throw ValidationException::withMessages([
                'username' => 'Password salah.',
            ]);
        }

        Auth::login($siswa->user, $request->boolean('remember'));

    } else {
        // Logika untuk Admin via Username
        // Kita gunakan attempt agar lebih aman
        if (!Auth::attempt(['username' => $loginValue, 'password' => $request->password], $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'username' => __('auth.failed'),
            ]);
        }
    }

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