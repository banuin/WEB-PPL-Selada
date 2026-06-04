<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class AdminPemesananController extends Controller
{
    // 1. Menampilkan Daftar Pesanan Aktif (Belum Selesai)
    public function index()
    {
        $pemesanans = Pemesanan::with('pelanggan')
            ->where('status_pembayaran', '!=', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.pemesanan.index', compact('pemesanans'));
    }

    // 2. Menampilkan Riwayat Pesanan (Sudah Selesai)
    public function riwayat()
    {
        $pemesanans = Pemesanan::with('pelanggan')
            ->where('status_pembayaran', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.pemesanan.riwayat', compact('pemesanans'));
    }

    // 3. Menampilkan Detail 1 Pesanan & Bukti Transfer
    public function show($id)
    {
        $pemesanan = Pemesanan::with(['pelanggan', 'detailPemesanan.katalog'])->findOrFail($id);
        
        return view('admin.pemesanan.detail', compact('pemesanan'));
    }

    // 4. Memproses Perubahan Status oleh Admin
    public function updateStatus(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->update([
            'status_pembayaran' => $request->status
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui menjadi: ' . $request->status);
    }
}