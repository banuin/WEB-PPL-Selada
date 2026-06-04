@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    
    {{-- Poin 10: Menampilkan pesan error validasi tanggal jika kosong --}}
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-xl font-bold shadow-sm flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Header & Form Filter --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Laporan Penjualan</h1>
            <p class="text-gray-500 mt-1">Pantau performa transaksi dan stok SELADAKU.</p>
        </div>

        {{-- Form Filter Periode (Poin 5, 6, 7, 8) --}}
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="flex flex-wrap items-end gap-3 bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            
            {{-- Pilihan Jenis Laporan --}}
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Jenis Laporan</label>
                <select name="jenis_laporan" class="text-sm border-gray-300 rounded-lg focus:ring-[#2F8540] focus:border-[#2F8540] h-[42px]">
                    <option value="semua" {{ $jenisLaporan == 'semua' ? 'selected' : '' }}>Semua Transaksi</option>
                    <option value="sukses" {{ $jenisLaporan == 'sukses' ? 'selected' : '' }}>Transaksi Selesai</option>
                    <option value="pending" {{ $jenisLaporan == 'pending' ? 'selected' : '' }}>Transaksi Tertunda</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Mulai Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="text-sm border-gray-300 rounded-lg focus:ring-[#2F8540] focus:border-[#2F8540] h-[42px]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="text-sm border-gray-300 rounded-lg focus:ring-[#2F8540] focus:border-[#2F8540] h-[42px]">
            </div>
            
            {{-- Tombol Filter --}}
            <button type="submit" name="filter_btn" value="1" class="bg-[#2F8540] hover:bg-green-800 text-white px-5 py-2 rounded-lg text-sm font-bold transition h-[42px] flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Tampilkan
            </button>
        </form>
    </div>

    {{-- Grid 4 Laporan Utama (Poin 16) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        
        {{-- Card 1: Pemasukan --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center relative overflow-hidden">
            <span class="text-sm font-bold text-gray-500 mb-2 relative z-10">Total Pemasukan</span>
            <span class="text-2xl font-black text-[#2F8540] relative z-10">Rp{{ number_format($totalPemasukan, 0, ',', '.') }}</span>
        </div>

        {{-- Card 2: Transaksi --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center">
            <span class="text-sm font-bold text-gray-500 mb-2">Total Transaksi</span>
            <span class="text-2xl font-black text-gray-800">{{ $totalTransaksi }} <span class="text-sm font-medium text-gray-400">Order</span></span>
        </div>

        {{-- Card 3: Penjualan --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center">
            <span class="text-sm font-bold text-gray-500 mb-2">Produk Terjual</span>
            <span class="text-2xl font-black text-gray-800">{{ $totalTerjual }} <span class="text-sm font-medium text-gray-400">Item/Kg</span></span>
        </div>

        {{-- Card 4: Stok --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center border-l-4 border-l-[#2F8540]">
            <span class="text-sm font-bold text-gray-500 mb-2">Sisa Stok Global</span>
            <span class="text-2xl font-black text-gray-800">{{ $stokProduk }} <span class="text-sm font-medium text-gray-400">Tersedia</span></span>
        </div>
    </div>

    {{-- Tabel Rincian Transaksi (Poin 13) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800">Rincian Laporan Transaksi</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-white text-gray-500 font-bold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Nama Pelanggan</th>
                        <th class="px-6 py-4">Nama & Jumlah Produk</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Total Transaksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse ($transaksi as $trx)
                    <tr class="hover:bg-gray-50 transition">
                        
                        {{-- 13a. Tanggal Pemesanan --}}
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($trx->tanggal_pemesanan)->format('d M Y') }}</td>
                        
                        {{-- 13b. Nama Pelanggan --}}
                        <td class="px-6 py-4 font-medium">{{ $trx->pelanggan->name ?? 'Pelanggan (Terhapus)' }}</td>
                        
                        {{-- 13c & 13d. Nama dan Jumlah Produk --}}
                        <td class="px-6 py-4">
                            <ul class="list-disc list-inside text-xs font-medium text-gray-600 space-y-1">
                                @forelse($trx->detailPemesanan as $detail)
                                    <li>{{ $detail->katalog->judul ?? 'Produk Dihapus' }} <span class="font-bold text-gray-800">({{ $detail->jumlah }} Kg)</span></li>
                                @empty
                                    <li>-</li>
                                @endforelse
                            </ul>
                        </td>

                        {{-- 13f. Status Pemesanan --}}
                        <td class="px-6 py-4">
                            @if($trx->status_pembayaran == 'Selesai')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Selesai</span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">{{ $trx->status_pembayaran }}</span>
                            @endif
                        </td>
                        
                        {{-- 13e. Total Transaksi --}}
                        <td class="px-6 py-4 text-right font-bold text-[#2F8540]">Rp{{ number_format($trx->total_pembayaran, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    
                    {{-- Poin 14: Pesan jika data tidak ditemukan --}}
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center opacity-60">
                                <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-gray-600 text-base font-semibold">Data laporan tidak ditemukan.</p>
                                <p class="text-gray-400 text-xs mt-1">Coba sesuaikan ulang filter rentang tanggal di atas.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection