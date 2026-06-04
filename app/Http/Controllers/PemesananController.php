<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    // Menampilkan Halaman Form Checkout
    public function checkout($id)
    {
        $katalog = Katalog::findOrFail($id);
        return view('pelanggan.pemesanan.checkout', compact('katalog'));
    }

    // Memproses Data Pemesanan & Foto Bukti Transfer (Dari Pop-Up)
    public function proses(Request $request)
    {
        // 1. Validasi Input dan File Bukti Transfer (Tambahkan validasi berat)
        $request->validate([
            'id_produk'         => 'required|exists:katalogs,id',
            'jumlah'            => 'required|numeric|min:1',
            'berat'             => 'required|numeric|min:10', // <--- Menangkap data paket
            'metode_pengiriman' => 'required',
            'bukti_transfer'    => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $katalog = Katalog::findOrFail($request->id_produk);
        
        // 2. Kalkulasi Pintar Shinta
        // Harga Paket = Harga Dasar (1 KG) x Berat (Misal: 2000 x 20 = 40.000)
        $hargaPaket = $katalog->harga * $request->berat;
        
        // Total Akhir = Harga Paket x Jumlah Pesanan
        $totalPembayaran = $hargaPaket * $request->jumlah;

        // 3. Simpan Foto Bukti Transfer ke Storage
        $buktiPath = $request->file('bukti_transfer')->store('bukti_pembayaran', 'public');

        // 4. Simpan ke Tabel Pemesanan
        $pemesanan = Pemesanan::create([
            'id_pelanggan'      => Auth::id(),
            'kode_pemesanan'    => 'ORD-' . strtoupper(uniqid()),
            'tanggal_pemesanan' => now(),
            'metode_pengiriman' => $request->metode_pengiriman,
            'total_pembayaran'  => $totalPembayaran,
            'bukti_transfer'    => $buktiPath,
            'status_pembayaran' => 'Menunggu Verifikasi',
        ]);

        // 5. Simpan ke Tabel Detail Pemesanan
        DetailPemesanan::create([
            'id_pemesanan'     => $pemesanan->id,
            'id_produk'        => $katalog->id,
            'harga_saat_pesan' => $hargaPaket, // <--- INI KUNCI AGAR STRUK NYA BENAR!
            'jumlah'           => $request->jumlah,
            'subtotal'         => $totalPembayaran,
        ]);

        // 6. Kurangi Stok Katalog dengan Benar (Jumlah bungkus dikali berat paket)
        $totalStokBerkurang = $request->jumlah * $request->berat;
        $katalog->decrement('stok', $totalStokBerkurang);

        return redirect()->route('pelanggan.pemesanan.show', $pemesanan->id)->with('success_payment', true);
    }

    // Menampilkan pesanan aktif (Selain "Selesai")
    public function indexPelanggan()
    {
        $pemesanans = Pemesanan::with('pelanggan')
            ->where('id_pelanggan', Auth::id())
            ->where('status_pembayaran', '!=', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pelanggan.pemesanan.index', compact('pemesanans'));
    }

    // Menampilkan riwayat pesanan (Hanya "Selesai")
    public function riwayatPelanggan()
    {
        $pemesanans = Pemesanan::with('pelanggan')
            ->where('id_pelanggan', Auth::id())
            ->where('status_pembayaran', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pelanggan.pemesanan.riwayat', compact('pemesanans'));
    }

    public function show($id)
    {
        // Ambil data pemesanan beserta detail dan pelanggannya
        $pemesanan = Pemesanan::with(['detailPemesanan.katalog', 'pelanggan'])->findOrFail($id);
        
        return view('pelanggan.pemesanan.detail', compact('pemesanan'));
    }
}