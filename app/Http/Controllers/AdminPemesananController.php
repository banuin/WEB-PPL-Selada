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
            ->whereNotIn('status_pembayaran', ['Selesai', 'Dibatalkan'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.pemesanan.index', compact('pemesanans'));
    }

    // 2. Menampilkan Riwayat Pesanan (Sudah Selesai)
    public function riwayat()
    {
        $pemesanans = Pemesanan::with('pelanggan')
            ->whereIn('status_pembayaran', ['Selesai', 'Dibatalkan'])
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
        $pemesanan = Pemesanan::with('detailPemesanan.katalog')->findOrFail($id);
        $statusLama = $pemesanan->status_pembayaran;
        $statusBaru = $request->status;

        // Jika dibatalkan oleh admin, dan status sebelumnya bukan dibatalkan, maka kembalikan stok
        // LOGIKA BARU: Jika status sebelumnya sudah 'Dikirim', jangan kembalikan stok karena selada mungkin sudah busuk.
        if ($statusBaru == 'Dibatalkan' && $statusLama != 'Dibatalkan') {
            if ($statusLama != 'Dikirim') {
                foreach ($pemesanan->detailPemesanan as $detail) {
                    $katalog = $detail->katalog;
                    if ($katalog && $katalog->harga > 0) {
                        $berat = $detail->harga_saat_pesan / $katalog->harga;
                        $stokKembali = $detail->jumlah * $berat;
                        $katalog->increment('stok', $stokKembali);
                    }
                }
            }
        }

        $pemesanan->update([
            'status_pembayaran' => $statusBaru
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui menjadi: ' . $statusBaru);
    }
}