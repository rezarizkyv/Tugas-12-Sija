<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — EduVerse SMKN 1 Medelin</title>
    
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
            --slate-900: #0f172a;
            --slate-800: #1e293b;
            --slate-600: #475569;
            --slate-400: #94a3b8;
            --slate-300: #cbd5e1;
            --slate-200: #e2e8f0;
            --white: #ffffff;
            --red-400: #f87171;
        }

        html, body {
            min-height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--slate-900);
            color: var(--slate-200);
            overflow-x: hidden;
        }

        /* ======= BACKGROUND ANIMATED ======= */
        .login-bg {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #0a0f1e 0%, #0d1b3e 40%, #0f1f45 70%, #0a0f1e 100%);
            z-index: 0;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.35;
            animation: drift 12s ease-in-out infinite;
        }
        .orb-1 { width: 600px; height: 600px; background: radial-gradient(circle, #0ea5e9 0%, transparent 70%); top: -200px; left: -150px; animation-duration: 14s; }
        .orb-2 { width: 500px; height: 500px; background: radial-gradient(circle, #6366f1 0%, transparent 70%); bottom: -180px; right: -120px; animation-duration: 18s; animation-delay: -6s; }

        .grid-overlay {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(56,189,248,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(56,189,248,0.04) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        @keyframes drift {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33%       { transform: translate(40px, -30px) scale(1.05); }
            66%       { transform: translate(-30px, 20px) scale(0.97); }
        }

        /* ======= MAIN WRAPPER ======= */
        .login-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.5rem;
        }

        .login-card {
            width: 100%;
            max-width: 500px;
            background: rgba(15, 23, 42, 0.75);
            border: 1px solid rgba(56, 189, 248, 0.15);
            border-radius: 24px;
            padding: 2.5rem;
            backdrop-filter: blur(24px);
            box-shadow: 0 0 0 1px rgba(56,189,248,0.08), 0 32px 64px rgba(0,0,0,0.5), 0 0 80px rgba(14,165,233,0.08) inset;
            animation: slideUp 0.6s cubic-bezier(0.16,1,0.3,1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px) scale(0.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ======= LOGO & HEADING ======= */
        .logo-wrap { text-align: center; margin-bottom: 2rem; }
        .logo-title { font-family: 'Poppins', sans-serif; font-weight: 900; font-size: 1.5rem; color: var(--white); }
        .logo-title span { color: #38bdf8; }
        
        .card-heading { text-align: center; margin-bottom: 1.5rem; }
        .card-heading h1 { font-size: 1.3rem; font-weight: 800; color: var(--white); }
        .card-heading p { font-size: 0.82rem; color: var(--slate-400); margin-top: 4px; }

        /* ======= FORM ======= */
        .form-group { margin-bottom: 1rem; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        
        .form-label { display: block; font-size: 0.8rem; font-weight: 700; color: var(--slate-300); margin-bottom: 0.5rem; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--slate-600); font-size: 0.85rem; }
        
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
        .form-input:focus { border-color: #38bdf8; background: rgba(30, 41, 59, 0.9); box-shadow: 0 0 0 3px rgba(56,189,248,0.12); }
        .form-input.input-error { border-color: var(--red-400); }
        
        .field-error { font-size: 0.78rem; font-weight: 600; color: var(--red-400); margin-top: 0.35rem; display: flex; align-items: center; gap: 4px; }

        .btn-login {
            width: 100%;
            padding: 0.85rem;
            border-radius: 14px;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 800;
            color: white;
            border: none;
            cursor: pointer;
            background: linear-gradient(135deg, #0ea5e9 0%, #4f46e5 100%);
            box-shadow: 0 8px 24px rgba(14,165,233,0.4);
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(14,165,233,0.5); }
        
        .forgot-link { font-size: 0.85rem; font-weight: 700; color: #38bdf8; text-decoration: none; }
        .forgot-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="login-bg">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="grid-overlay"></div>
</div>

<div class="login-wrapper">
    <div class="login-card">
        
        <div class="logo-wrap">
            <h2 class="logo-title">Edu<span>Verse</span></h2>
        </div>

        <div class="card-heading">
            <h1>Daftar Akun Baru</h1>
            <p>Buat akun untuk mengakses e-learning EduVerse</p>
        </div>

        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            <div class="form-group">
                <label class="form-label" for="name"><i class="fa-solid fa-user text-blue-400 mr-1"></i> Nama Lengkap</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input id="name" type="text" name="name" class="form-input {{ $errors->has('name') ? 'input-error' : '' }}" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required autofocus>
                </div>
                @error('name') <p class="field-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="username"><i class="fa-solid fa-at text-blue-400 mr-1"></i> Username</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-at input-icon"></i>
                    <input id="username" type="text" name="username" class="form-input {{ $errors->has('username') ? 'input-error' : '' }}" value="{{ old('username') }}" placeholder="contoh: budisantoso" required>
                </div>
                @error('username') <p class="field-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email"><i class="fa-solid fa-envelope text-blue-400 mr-1"></i> Alamat Email</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input id="email" type="email" name="email" class="form-input {{ $errors->has('email') ? 'input-error' : '' }}" value="{{ old('email') }}" placeholder="contoh@smkn1medelin.sch.id" required>
                </div>
                @error('email') <p class="field-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p> @enderror
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="nis"><i class="fa-solid fa-id-card text-blue-400 mr-1"></i> NIS (Opsional)</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-id-card input-icon"></i>
                        <input id="nis" type="text" name="nis" class="form-input" value="{{ old('nis') }}" placeholder="Nomor Induk">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="kelas"><i class="fa-solid fa-door-open text-blue-400 mr-1"></i> Kelas (Opsional)</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-door-open input-icon"></i>
                        <input id="kelas" type="text" name="kelas" class="form-input" value="{{ old('kelas') }}" placeholder="XII RPL 1">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password"><i class="fa-solid fa-lock text-blue-400 mr-1"></i> Password</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input id="password" type="password" name="password" class="form-input {{ $errors->has('password') ? 'input-error' : '' }}" placeholder="Minimal 6 karakter" required>
                </div>
                @error('password') <p class="field-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation"><i class="fa-solid fa-lock text-blue-400 mr-1"></i> Konfirmasi Password</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fa-solid fa-user-plus mr-2"></i> Buat Akun
            </button>
        </form>
        
        <div style="text-align: center; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(56,189,248,0.1);">
            <p style="font-size: 0.85rem; color: var(--slate-400);">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="forgot-link">Masuk di sini</a>
            </p>
        </div>

    </div>
</div>

</body>
</html>
