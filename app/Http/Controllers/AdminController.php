<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Wajib ditambahkan agar bisa memanggil tabel users

class AdminController extends Controller
{
    public function daftarPelanggan()
    {
        $pelanggan = User::where('role', 'pelanggan')->get();
        return view('admin.daftarpelanggan', compact('pelanggan'));
    }

    public function detailPelanggan($id)
    {
        $pelanggan = User::findOrFail($id);
        return view('admin.detailpelanggan', compact('pelanggan'));
    }

    public function hapusPelanggan($id)
    {
        $pelanggan = User::findOrFail($id);
        
        $nama_akun = $pelanggan->username; 

        if ($pelanggan->role != 'admin') {
            $pelanggan->delete();
        }
        return redirect()->route('admin.pelanggan.index')->with('success', 'Akun @' . $nama_akun . ' berhasil dihapus');
    }
}