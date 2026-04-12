<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Absensi Siswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5086 50%, #1e3a5f 100%);
        }

        .login-wrapper {
            display: flex;
            width: 900px;
            min-height: 500px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        }

        /* Sisi Kiri */
        .login-left {
            flex: 1;
            background: linear-gradient(160deg, #1e3a5f, #0f2340);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 50px 40px;
            color: white;
            text-align: center;
        }

        .login-left .icon {
            font-size: 70px;
            margin-bottom: 20px;
        }

        .login-left h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-left p {
            font-size: 14px;
            color: #94a3b8;
            line-height: 1.6;
        }

        .login-left .divider {
            width: 50px;
            height: 3px;
            background: #60a5fa;
            margin: 20px auto;
            border-radius: 5px;
        }

        .login-left .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
            font-size: 13px;
            color: #cbd5e1;
        }

        /* Sisi Kanan */
        .login-right {
            flex: 1;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px 45px;
        }

        .login-right h2 {
            font-size: 24px;
            font-weight: 700;
            color: #1e3a5f;
            margin-bottom: 5px;
        }

        .login-right .subtitle {
            font-size: 14px;
            color: #94a3b8;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #94a3b8;
        }

        .form-control {
            width: 100%;
            padding: 11px 12px 11px 38px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            color: #374151;
            transition: all 0.2s;
            background: #f8fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: #1e3a5f;
            background: white;
            box-shadow: 0 0 0 3px rgba(30,58,95,0.1);
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .remember-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #1e3a5f;
        }

        .remember-row label {
            font-size: 13px;
            color: #64748b;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #1e3a5f, #2d5086);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #2d5086, #1e3a5f);
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(30,58,95,0.3);
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 12px;
            color: #94a3b8;
        }
        /* Transition */
.login-wrapper {
    animation: fadeSlideUp 0.6s ease forwards;
}

@keyframes fadeSlideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.btn-login {
    position: relative;
    overflow: hidden;
}

.btn-login::after {
    content: '';
    position: absolute;
    width: 0;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(255,255,255,0.1);
    transition: width 0.3s ease;
}

.btn-login:hover::after {
    width: 100%;
}

.form-control {
    transition: all 0.3s ease;
}

.login-left .info-item {
    opacity: 0;
    transform: translateX(-20px);
    animation: slideIn 0.5s ease forwards;
}

.login-left .info-item:nth-child(1) { animation-delay: 0.3s; }
.login-left .info-item:nth-child(2) { animation-delay: 0.5s; }
.login-left .info-item:nth-child(3) { animation-delay: 0.7s; }

@keyframes slideIn {
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
    </style>
</head>
<body>

<div class="login-wrapper">
    {{-- Kiri --}}
    <div class="login-left">
        <div class="icon">🏫</div>
        <h1>Sistem Absensi Siswa</h1>
        <div class="divider"></div>
        <p>Platform manajemen kehadiran siswa yang mudah, cepat, dan akurat.</p>

        <div class="info-item">✅ Rekap absensi otomatis</div>
        <div class="info-item">📊 Laporan lengkap per kelas</div>
        <div class="info-item">👤 Multi role pengguna</div>
    </div>

    {{-- Kanan --}}
    <div class="login-right">
        <h2>Selamat Datang 👋</h2>
        <p class="subtitle">Masuk untuk melanjutkan ke dashboard</p>

        {{-- Error --}}
        @if($errors->any())
            <div class="alert-danger">
                ⚠️ {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Email</label>
                <div class="input-wrapper">
                    <span class="input-icon">✉️</span>
                    <input type="text" name="email" class="form-control"
                        value="{{ old('email') }}"
                        placeholder="NIS atau Email" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password" class="form-control"
                           placeholder="••••••••" required>
                </div>
            </div>

            <div class="remember-row">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login">Masuk →</button>
        </form>

        <div class="footer-text">
            &copy; {{ date('Y') }} Sistem Absensi Siswa. All rights reserved.
        </div>
    </div>
</div>

<script>
    // Loading transition saat submit
    document.querySelector('form').addEventListener('submit', function() {
        const btn = document.querySelector('.btn-login');
        btn.innerHTML = 'Memuat... ⏳';
        btn.style.opacity = '0.8';
        btn.disabled = true;
    });
</script>
</body>
</html>