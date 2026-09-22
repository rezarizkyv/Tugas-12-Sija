<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        // Jika sudah login, redirect sesuai role
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();

            return $this->redirectByRole();
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau password tidak cocok. Silakan coba lagi.']);
    }

    /**
     * Tampilkan halaman register.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses register.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'username.required'  => 'Username wajib diisi.',
            'username.unique'    => 'Username sudah terdaftar.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user', // Default register adalah user biasa
            'nis'      => $request->nis,
            'kelas'    => $request->kelas,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Akun berhasil dibuat. Selamat datang di EduVerse!');
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout. Sampai jumpa!');
    }

    /**
     * Redirect berdasarkan role user.
     */
    private function redirectByRole()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang, Administrator! 👑');
        }

        return redirect()->route('dashboard')
            ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
    }
}
