<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin() {
        return view('auth.login');
    }

    // Memproses data login menggunakan USERNAME & PASSWORD kustom kamu
    public function login(Request $request) {
        $request->validate([
            'Username' => 'required',
            'Password' => 'required'
        ]);

        // Cari data user berdasarkan Username di database kustom
        $user = User::where('Username', $request->Username)->first();

        // Cek apakah usernya ada, dan cocokkan password manual (P kapital)
        if ($user && Hash::check($request->Password, $user->Password)) {
            
            // Daftarkan session login user ke sistem Laravel secara sah
            Auth::login($user);
            $request->session()->regenerate();

            // Ambil email dari database dan ubah ke huruf kecil semua biar aman
            $email = strtolower($user->Email);

            // 🔥 LOGIKA BARU: PEMILAH HALAMAN BERDASARKAN DOMAIN EMAIL 🔥
            if (str_ends_with($email, '@admin.id')) {
                return redirect()->intended('/admin/dashboard');
            } elseif (str_ends_with($email, '@petugas.id')) {
                return redirect()->intended('/petugas/dashboard');
            } else {
                return redirect()->intended('/dashboard');
            }
        }

        // Jika data tidak cocok, kembalikan dengan pesan eror manis
        return back()->withErrors(['loginError' => 'Username atau password salah, Bung!']);
    }

    // Menampilkan halaman register
    public function showRegister() {
        return view('auth.register');
    }

    // Memproses pendaftaran user baru lewat halaman depan
    public function register(Request $request) {
        $request->validate([
            'Username' => 'required|unique:user,Username|max:255',
            'Password' => 'required|min:5',
            'Email' => 'required|email|unique:user,Email',
            'NamaLengkap' => 'required|max:255',
            'Alamat' => 'required',
        ]);

        User::create([
            'Username' => $request->Username,
            'Password' => Hash::make($request->Password), // Di-hash aman agar tidak mentah di DB
            'Email' => $request->Email,
            'NamaLengkap' => $request->NamaLengkap,
            'Alamat' => $request->Alamat,
            'role' => 'user', // Default awal tetap user umum
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Proses Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}