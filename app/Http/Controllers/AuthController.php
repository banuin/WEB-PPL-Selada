<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function loginProses(Request $request) {
        // Ambil input dari form
        $username = $request->input('username'); // Laravel defaultnya pakai email, tapi kita sesuaikan
        $password = $request->input('password');

        // Cari di database: yang email/username-nya cocok DAN password-nya persis
        $user = DB::table('users')
                    ->where('email', $username)
                    ->where('password', $password)
                    ->first();

        if ($user) {
            // Jika ketemu, simpan data user ke Session agar web "ingat" siapa yang login
            session(['user_id' => $user->id, 'role' => $user->role, 'name' => $user->name]);
            
            return redirect()->route('dashboard');
        } else {
            return back()->with('error', 'Username atau Password salah!');
        }
    }

    public function showDashboard() {
        $role = session('role');

        if ($role == 'admin') {
            return view('admin.dashboard');
        } elseif ($role == 'pelanggan') {
            return view('pelanggan.home');
        }
        return redirect()->route('login');
    }
}