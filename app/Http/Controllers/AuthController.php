<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use App\Models\Katalog;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function loginProses(Request $request)
    {
        $username = $request->input('username'); 
        $password = $request->input('password');

        $user = User::where('email', $username)
                    ->orWhere('username', $username)
                    ->first();

        if ($user) {
            $authenticated = false;
            // Pengecekan aman untuk password yang sudah di-hash (Bcrypt)
            if (str_starts_with($user->password, '$2y$')) {
                $authenticated = Hash::check($password, $user->password);
            } else {
                // Pencocokan teks biasa (plaintext) sebagai cadangan untuk data uji coba lama
                $authenticated = ($user->password === $password);
                if ($authenticated) {
                    // Otomatis konversi ke hash untuk keamanan
                    $user->password = Hash::make($password);
                    $user->save();
                }
            }

            if ($authenticated) {
                // Login user menggunakan sistem bawaan Laravel
                Auth::login($user);
                $request->session()->regenerate();

                if ($user->role == 'admin') {
                    return redirect()->route('admin.dashboard')->with('success', 'Login berhasil');
                } else {
                    return redirect()->route('pelanggan.home')->with('success', 'Login berhasil');
                }
            }
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    public function loginApi(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->username)
                    ->orWhere('username', $request->username)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Username atau password salah'
            ], 401); 
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => 'Login Berhasil',
            'data_user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        

        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }

    public function showDashboard() 
    {
        $user = Auth::user();

        // Cek jika user mencoba akses rute admin tapi rolenya bukan admin
        if (request()->is('admin/*') && $user->role !== 'admin') {
            return redirect()->route('pelanggan.home');
        }

        // Ambil data katalog (misalnya 6 terbaru agar tampilan rapi)
        $katalogs = \App\Models\Katalog::latest()->take(6)->get();

        if ($user->role == 'admin') {
            // Kirim $katalogs ke dashboard admin
            return view('admin.dashboard', compact('katalogs'));
        } elseif ($user->role == 'pelanggan') {
            // Pastikan data artikel DAN katalog dikirim ke home pelanggan
            $articles = \App\Models\Artikel::latest()->get();
            return view('pelanggan.home', compact('articles', 'katalogs'));
        }
        
        return redirect()->route('login');
    }

    public function registerProses(Request $request)
    {
        $kecamatans = [
            'Ajung', 'Ambulu', 'Arjasa', 'Balung', 'Bangsalsari', 'Gumukmas', 'Jelbuk', 'Jenggawah',
            'Jombang', 'Kalisat', 'Kaliwates', 'Kencong', 'Ledokombo', 'Mayang', 'Mumbulsari', 'Pakusari',
            'Panti', 'Patrang', 'Puger', 'Rambipuji', 'Semboro', 'Silo', 'Sukorambi', 'Sukowono',
            'Sumberbaru', 'Sumberjambe', 'Sumbersari', 'Tanggul', 'Tempurejo', 'Umbulsari', 'Wuluhan'
        ];

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'kecamatan' => 'required|in:' . implode(',', $kecamatans),
            'detail_alamat' => 'required',
            'nomor_telpon' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
        ], [
            'name.required' => 'Mohon lengkapi data anda',
            'username.required' => 'Mohon lengkapi data anda',
            'kecamatan.required' => 'Mohon pilih kecamatan Anda',
            'kecamatan.in' => 'Kecamatan harus berada di wilayah Kabupaten Jember',
            'detail_alamat.required' => 'Mohon lengkapi detail alamat Anda',
            'nomor_telpon.required' => 'Mohon lengkapi data anda',
            'email.required' => 'Mohon lengkapi data anda',
            'password.required' => 'Mohon lengkapi data anda',
        ]);

        $alamat_gabungan = $request->detail_alamat . ', Kec. ' . $request->kecamatan;

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'kecamatan' => $request->kecamatan,
            'detail_alamat' => $request->detail_alamat,
            'alamat' => $alamat_gabungan,
            'nomor_telpon' => $request->nomor_telpon,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'role' => 'pelanggan',
        ]);

        return redirect()->route('register')->with('success', 'Registrasi berhasil!');
    }

    public function showProfil()
    {
        $user = Auth::user(); 

        if ($user->role == 'admin') {
            return view('admin.profil', compact('user'));
        } else {
            return view('pelanggan.profil', compact('user'));
        }
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $messages = [
            'required' => 'Harap lengkapi profil anda',
            'kecamatan.required' => 'Mohon pilih kecamatan Anda',
            'kecamatan.in' => 'Kecamatan harus berada di wilayah Kabupaten Jember',
            'detail_alamat.required' => 'Mohon lengkapi detail alamat Anda',
        ];

        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'nomor_telpon' => 'required', 
        ];

        if ($user->role != 'admin') {
            $kecamatans = [
                'Ajung', 'Ambulu', 'Arjasa', 'Balung', 'Bangsalsari', 'Gumukmas', 'Jelbuk', 'Jenggawah',
                'Jombang', 'Kalisat', 'Kaliwates', 'Kencong', 'Ledokombo', 'Mayang', 'Mumbulsari', 'Pakusari',
                'Panti', 'Patrang', 'Puger', 'Rambipuji', 'Semboro', 'Silo', 'Sukorambi', 'Sukowono',
                'Sumberbaru', 'Sumberjambe', 'Sumbersari', 'Tanggul', 'Tempurejo', 'Umbulsari', 'Wuluhan'
            ];
            $rules['kecamatan'] = 'required|in:' . implode(',', $kecamatans);
            $rules['detail_alamat'] = 'required';
        }

        $request->validate($rules, $messages);

        $dataUpdate = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'nomor_telpon' => $request->nomor_telpon,
        ];

        if ($user->role != 'admin') {
            $dataUpdate['kecamatan'] = $request->kecamatan;
            $dataUpdate['detail_alamat'] = $request->detail_alamat;
            $dataUpdate['alamat'] = $request->detail_alamat . ', Kec. ' . $request->kecamatan;
        }

        $user->update($dataUpdate);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('profil.show')->with('success', 'Profil berhasil diperbarui!');
    }
}