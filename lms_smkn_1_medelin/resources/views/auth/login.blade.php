<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — EduVerse SMKN 1 Medelin</title>
    <meta name="description" content="Login ke portal LMS EduVerse SMKN 1 Medelin untuk mengakses e-learning, presensi, dan ujian online.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@700;800;900&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue-500: #0ea5e9;
            --blue-600: #0284c7;
            --blue-700: #0369a1;
            --indigo-500: #6366f1;
            --indigo-600: #4f46e5;
            --slate-900: #0f172a;
            --slate-800: #1e293b;
            --slate-700: #334155;
            --slate-600: #475569;
            --slate-400: #94a3b8;
            --slate-300: #cbd5e1;
            --slate-200: #e2e8f0;
            --white: #ffffff;
            --red-400: #f87171;
            --green-400: #4ade80;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--slate-900);
            color: var(--slate-200);
            overflow: hidden;
        }

        /* ======= BACKGROUND ANIMATED ======= */
        .login-bg {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #0a0f1e 0%, #0d1b3e 40%, #0f1f45 70%, #0a0f1e 100%);
            z-index: 0;
            overflow: hidden;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.35;
            animation: drift 12s ease-in-out infinite;
        }
        .orb-1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, #0ea5e9 0%, transparent 70%);
            top: -200px; left: -150px;
            animation-duration: 14s;
        }
        .orb-2 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #6366f1 0%, transparent 70%);
            bottom: -180px; right: -120px;
            animation-duration: 18s;
            animation-delay: -6s;
        }
        .orb-3 {
            width: 350px; height: 350px;
            background: radial-gradient(circle, #0284c7 0%, transparent 70%);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            animation-duration: 22s;
            animation-delay: -10s;
            opacity: 0.2;
        }

        @keyframes drift {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33%       { transform: translate(40px, -30px) scale(1.05); }
            66%       { transform: translate(-30px, 20px) scale(0.97); }
        }

        /* Grid pattern overlay */
        .grid-overlay {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(56,189,248,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(56,189,248,0.04) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        /* ======= MAIN WRAPPER ======= */
        .login-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* ======= LOGIN CARD ======= */
        .login-card {
            width: 100%;
            max-width: 440px;
            background: rgba(15, 23, 42, 0.75);
            border: 1px solid rgba(56, 189, 248, 0.15);
            border-radius: 24px;
            padding: 2.5rem;
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            box-shadow:
                0 0 0 1px rgba(56,189,248,0.08),
                0 32px 64px rgba(0,0,0,0.5),
                0 0 80px rgba(14,165,233,0.08) inset;
            animation: slideUp 0.6s cubic-bezier(0.16,1,0.3,1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px) scale(0.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ======= LOGO ======= */
        .logo-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
        }

        .logo-icon-wrap {
            position: relative;
            margin-bottom: 1rem;
        }

        .logo-icon {
            width: 72px; height: 72px;
            border-radius: 20px;
            background: linear-gradient(135deg, #0ea5e9 0%, #4f46e5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            box-shadow: 0 8px 32px rgba(14,165,233,0.5);
            position: relative;
            z-index: 1;
        }

        .logo-icon-ring {
            position: absolute;
            inset: -6px;
            border-radius: 26px;
            border: 1.5px solid rgba(56,189,248,0.3);
            animation: ring-pulse 2.5s ease-in-out infinite;
        }

        @keyframes ring-pulse {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50%       { opacity: 0.8; transform: scale(1.04); }
        }

        .logo-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 900;
            font-size: 1.7rem;
            color: var(--white);
            letter-spacing: -0.02em;
            line-height: 1;
        }

        .logo-title span { color: #38bdf8; }

        .logo-subtitle {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--slate-400);
            margin-top: 4px;
        }

        /* ======= HEADING ======= */
        .card-heading {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .card-heading h1 {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.01em;
        }

        .card-heading p {
            font-size: 0.82rem;
            color: var(--slate-400);
            margin-top: 4px;
        }

        /* ======= FORM ======= */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--slate-300);
            margin-bottom: 0.5rem;
            letter-spacing: 0.02em;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--slate-600);
            font-size: 0.85rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-input {
            width: 100%;
            background: rgba(30, 41, 59, 0.7);
            border: 1.5px solid rgba(51, 65, 85, 0.8);
            border-radius: 12px;
            padding: 0.75rem 0.875rem 0.75rem 2.75rem;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            color: var(--white);
            outline: none;
            transition: all 0.25s ease;
        }

        .form-input::placeholder { color: var(--slate-600); }

        .form-input:focus {
            border-color: #38bdf8;
            background: rgba(30, 41, 59, 0.9);
            box-shadow: 0 0 0 3px rgba(56,189,248,0.12), 0 2px 8px rgba(0,0,0,0.2);
        }

        .form-input:focus ~ .input-icon,
        .input-wrap:focus-within .input-icon {
            color: #38bdf8;
        }

        .form-input.input-error {
            border-color: var(--red-400);
            box-shadow: 0 0 0 3px rgba(248,113,113,0.12);
        }

        /* Toggle password */
        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--slate-600);
            cursor: pointer;
            font-size: 0.85rem;
            padding: 2px;
            transition: color 0.2s;
        }
        .toggle-pw:hover { color: var(--slate-300); }

        /* ======= ERROR / ALERT ======= */
        .alert-error {
            background: rgba(248,113,113,0.12);
            border: 1px solid rgba(248,113,113,0.3);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
            animation: fadeIn 0.3s ease;
        }

        .alert-success {
            background: rgba(74,222,128,0.12);
            border: 1px solid rgba(74,222,128,0.3);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .alert-icon { font-size: 0.85rem; margin-top: 1px; flex-shrink: 0; }
        .alert-error .alert-icon  { color: var(--red-400); }
        .alert-success .alert-icon { color: var(--green-400); }

        .alert-text {
            font-size: 0.82rem;
            font-weight: 600;
            line-height: 1.4;
        }
        .alert-error .alert-text  { color: #fca5a5; }
        .alert-success .alert-text { color: #86efac; }

        .field-error {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--red-400);
            margin-top: 0.35rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ======= REMEMBER + FORGOT ======= */
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            margin-top: 0.25rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--slate-400);
            user-select: none;
        }

        .custom-check {
            width: 16px; height: 16px;
            border-radius: 5px;
            border: 1.5px solid var(--slate-600);
            background: rgba(30, 41, 59, 0.7);
            appearance: none;
            -webkit-appearance: none;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .custom-check:checked {
            background: linear-gradient(135deg, #0ea5e9, #4f46e5);
            border-color: #0ea5e9;
        }

        .custom-check:checked::after {
            content: '';
            position: absolute;
            left: 4px; top: 1px;
            width: 5px; height: 9px;
            border: 2px solid white;
            border-top: none; border-left: none;
            transform: rotate(45deg);
        }

        .forgot-link {
            font-size: 0.82rem;
            font-weight: 700;
            color: #38bdf8;
            text-decoration: none;
            transition: color 0.2s;
        }
        .forgot-link:hover { color: #7dd3fc; text-decoration: underline; }

        /* ======= SUBMIT BUTTON ======= */
        .btn-login {
            width: 100%;
            padding: 0.85rem;
            border-radius: 14px;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            color: white;
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #0ea5e9 0%, #4f46e5 100%);
            box-shadow: 0 8px 24px rgba(14,165,233,0.4);
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(14,165,233,0.5);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 4px 16px rgba(14,165,233,0.3);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before { left: 100%; }

        .btn-login .btn-icon { margin-right: 8px; }

        /* ======= DEMO ACCOUNTS ======= */
        .demo-section {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(56,189,248,0.1);
        }

        .demo-label {
            text-align: center;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--slate-600);
            margin-bottom: 0.875rem;
        }

        .demo-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.625rem;
        }

        .demo-card {
            background: rgba(30,41,59,0.6);
            border: 1px solid rgba(51,65,85,0.6);
            border-radius: 12px;
            padding: 0.75rem;
            cursor: pointer;
            transition: all 0.25s ease;
            text-align: center;
        }

        .demo-card:hover {
            border-color: rgba(56,189,248,0.4);
            background: rgba(14,165,233,0.08);
            transform: translateY(-2px);
        }

        .demo-card.admin-card:hover { border-color: rgba(251,191,36,0.5); background: rgba(251,191,36,0.06); }

        .demo-card-icon {
            font-size: 1.4rem;
            margin-bottom: 0.35rem;
        }

        .demo-card-role {
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .demo-card.admin-card .demo-card-role { color: #fbbf24; }
        .demo-card.user-card  .demo-card-role { color: #38bdf8; }

        .demo-card-info {
            font-size: 0.7rem;
            color: var(--slate-600);
            font-weight: 500;
            line-height: 1.4;
        }

        /* ======= FOOTER TEXT ======= */
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.75rem;
            color: var(--slate-600);
            font-weight: 500;
        }
    </style>
</head>
<body>

<!-- Animated Background -->
<div class="login-bg">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="grid-overlay"></div>
</div>

<!-- Login Wrapper -->
<div class="login-wrapper">
    <div class="login-card">

        <!-- Logo -->
        <div class="logo-wrap">
            <div class="logo-icon-wrap">
                <div class="logo-icon">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div class="logo-icon-ring"></div>
            </div>
            <h2 class="logo-title">Edu<span>Verse</span></h2>
            <p class="logo-subtitle">SMKN 1 Medelin &bull; LMS Portal</p>
        </div>

        <!-- Heading -->
        <div class="card-heading">
            <h1>Selamat Datang Kembali!</h1>
            <p>Masuk ke akun Anda untuk melanjutkan belajar</p>
        </div>

        <!-- Alert Sukses (logout / flash) -->
        @if(session('success'))
        <div class="alert-success" role="alert">
            <i class="fa-solid fa-circle-check alert-icon"></i>
            <p class="alert-text">{{ session('success') }}</p>
        </div>
        @endif

        <!-- Alert Error Global -->
        @if($errors->has('email') && !$errors->has('password'))
        <div class="alert-error" role="alert">
            <i class="fa-solid fa-circle-exclamation alert-icon"></i>
            <p class="alert-text">{{ $errors->first('email') }}</p>
        </div>
        @endif

        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label class="form-label" for="email">
                    <i class="fa-solid fa-envelope" style="margin-right:5px; color:#38bdf8;"></i>
                    Alamat Email
                </label>
                <div class="input-wrap">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-input {{ $errors->has('email') ? 'input-error' : '' }}"
                        value="{{ old('email') }}"
                        placeholder="contoh@smkn1medelin.sch.id"
                        autocomplete="email"
                        required
                        autofocus
                    >
                </div>
                @error('email')
                <p class="field-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label" for="password">
                    <i class="fa-solid fa-lock" style="margin-right:5px; color:#38bdf8;"></i>
                    Password
                </label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-input {{ $errors->has('password') ? 'input-error' : '' }}"
                        placeholder="Masukkan password Anda"
                        autocomplete="current-password"
                        required
                    >
                    <button type="button" class="toggle-pw" id="togglePw" aria-label="Toggle password visibility">
                        <i class="fa-solid fa-eye" id="togglePwIcon"></i>
                    </button>
                </div>
                @error('password')
                <p class="field-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Remember Me + Forgot -->
            <div class="remember-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember" class="custom-check" id="remember">
                    <span>Ingat saya</span>
                </label>
                <a href="#" class="forgot-link">Lupa password?</a>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-login" id="loginBtn">
                <i class="fa-solid fa-right-to-bracket btn-icon"></i>
                Masuk ke EduVerse
            </button>
        </form>

        <!-- Demo Accounts Section -->
        <div class="demo-section">
            <p class="demo-label">
                <i class="fa-solid fa-key" style="margin-right:4px;"></i>
                Akun Demo — Klik untuk isi otomatis
            </p>
            <div class="demo-cards">
                <div class="demo-card admin-card"
                     onclick="fillDemo('admin@smkn1medelin.sch.id','admin123')"
                     title="Login sebagai Admin">
                    <div class="demo-card-icon">👑</div>
                    <div class="demo-card-role">Admin</div>
                    <div class="demo-card-info">admin@smkn1<br>medelin.sch.id</div>
                </div>
                <div class="demo-card user-card"
                     onclick="fillDemo('siswa@smkn1medelin.sch.id','siswa123')"
                     title="Login sebagai Siswa">
                    <div class="demo-card-icon">🎓</div>
                    <div class="demo-card-role">Siswa</div>
                    <div class="demo-card-info">siswa@smkn1<br>medelin.sch.id</div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 1.5rem;">
                <p style="font-size: 0.85rem; color: var(--slate-400);">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="forgot-link">Daftar sekarang</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <p class="login-footer">
            &copy; 2026 EduVerse &mdash; SMKN 1 Medelin &bull; v4.0
        </p>

    </div>
</div>

<script>
    // Toggle password visibility
    const togglePw = document.getElementById('togglePw');
    const pwInput  = document.getElementById('password');
    const pwIcon   = document.getElementById('togglePwIcon');

    togglePw.addEventListener('click', () => {
        const isPassword = pwInput.type === 'password';
        pwInput.type = isPassword ? 'text' : 'password';
        pwIcon.className = isPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
    });

    // Fill demo credentials
    function fillDemo(email, password) {
        document.getElementById('email').value    = email;
        document.getElementById('password').value = password;

        // Highlight fields
        ['email', 'password'].forEach(id => {
            const el = document.getElementById(id);
            el.style.borderColor = '#38bdf8';
            el.style.boxShadow   = '0 0 0 3px rgba(56,189,248,0.2)';
            setTimeout(() => {
                el.style.borderColor = '';
                el.style.boxShadow   = '';
            }, 1200);
        });
    }

    // Loading state on submit
    document.getElementById('loginForm').addEventListener('submit', function() {
        const btn = document.getElementById('loginBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin btn-icon"></i> Memverifikasi...';
    });
</script>

</body>
</html>
