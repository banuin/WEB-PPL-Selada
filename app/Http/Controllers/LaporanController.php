<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Katalog;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Tangkap input filter
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $jenisLaporan = $request->input('jenis_laporan', 'semua');

        // Poin 10: Validasi jika tombol filter ditekan tapi tanggal kosong
        if ($request->has('filter_btn') && (!$startDate || !$endDate)) {
            return back()->with('error', 'Silakan pilih rentang tanggal terlebih dahulu.');
        }

        // Jika baru pertama buka halaman (belum filter), kosongkan tabel dulu atau set default
        if (!$startDate || !$endDate) {
            $transaksi = collect(); // Koleksi kosong
            return view('admin.laporan.index', [
                'transaksi' => $transaksi,
                'startDate' => '',
                'endDate' => '',
                'jenisLaporan' => 'semua',
                'totalTransaksi' => 0, 'totalPemasukan' => 0, 'totalTerjual' => 0, 'stokProduk' => 0
            ]);
        }

        // Poin 11 & 12: Mengambil data jika filter sudah lengkap
        // Pastikan memanggil relasi ke katalog agar bisa ambil nama produk (Poin 13c)
        $transaksi = Pemesanan::with(['pelanggan', 'detailPemesanan.katalog'])
            ->whereBetween('tanggal_pemesanan', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        // Logika sederhana untuk filter Poin 5 & 6 (Jenis Laporan)
        if ($jenisLaporan == 'sukses') {
            $transaksi->where('status_pembayaran', 'Selesai');
        } elseif ($jenisLaporan == 'pending') {
            $transaksi->where('status_pembayaran', '!=', 'Selesai');
        }

        $transaksi = $transaksi->get();

        // Hitung Ringkasan (Poin 16)
        $totalTransaksi = $transaksi->count();
        $totalPemasukan = $transaksi->where('status_pembayaran', 'Selesai')->sum('total_pembayaran');
        $totalTerjual = $transaksi->where('status_pembayaran', 'Selesai')->sum(function($item) {
            return $item->detailPemesanan->sum('jumlah');
        });
        $stokProduk = Katalog::sum('stok'); 

        return view('admin.laporan.index', compact(
            'startDate', 'endDate', 'jenisLaporan', 'transaksi', 
            'totalTransaksi', 'totalPemasukan', 'totalTerjual', 'stokProduk'
        ));
    }
}