<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\SendOtpMail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // 1. Tampilkan form untuk memasukkan email
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Proses pembuatan dan pengiriman OTP
    public function sendOtp(Request $request)
    {
        // Validasi: pastikan email diisi dan ada di tabel users
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem kami.'
        ]);

        // Generate 6 digit angka acak untuk OTP
        $otp = rand(100000, 999999);

        // Simpan ke tabel password_otps (jika email sudah ada, update OTP-nya)
        DB::table('password_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp, 
                'created_at' => Carbon::now()
            ]
        );

        // Kirim email menggunakan Mailable yang sudah kita buat
        Mail::to($request->email)->send(new SendOtpMail($otp));

        // Arahkan user ke halaman input OTP sambil membawa parameter email
        return redirect()->route('password.reset.form', ['email' => $request->email])
                         ->with('success', 'Kode OTP 6 digit telah dikirim ke email Anda.');
    }

    // 3. Tampilkan form untuk input OTP dan Password Baru
    public function showResetForm(Request $request)
    {
        // Tangkap email dari URL untuk ditampilkan di form
        $email = $request->query('email');
        return view('auth.reset-password', compact('email'));
    }

    // 4. Proses validasi OTP dan Update Password
    public function resetPassword(Request $request)
    {
        // Validasi inputan form reset
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric|digits:6',
            'password' => 'required|confirmed', // butuh input name="password_confirmation" di blade
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Cari OTP di database
        $otpRecord = DB::table('password_otps')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        // Jika OTP salah
        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau tidak valid.']);
        }

        // Cek apakah OTP sudah kadaluarsa (misal batasnya 15 menit)
        $createdAt = Carbon::parse($otpRecord->created_at);
        if (Carbon::now()->diffInMinutes($createdAt) > 15) {
            // Hapus OTP yang sudah basi
            DB::table('password_otps')->where('email', $request->email)->delete();
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan minta kode baru.']);
        }

        // Jika OTP benar dan belum kadaluarsa, ubah password user!
        $user = User::where('email', $request->email)->first();
        $user->password = $request->password;
        $user->save();

        // Hapus OTP dari database agar tidak bisa dipakai 2 kali
        DB::table('password_otps')->where('email', $request->email)->delete();
        $request->session()->flush();
        // Arahkan kembali ke halaman login dengan pesan sukses
        return redirect()->to('/login')->with('success', 'Password berhasil diubah!.');
    }
}