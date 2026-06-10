@extends('layouts.app')

@section('content')
<div class="p-8 md:p-12">

    <div class="max-w-6xl mx-auto">
        
        <!-- Header Halaman (Panah Kembali & Judul) -->
        <div class="flex items-center mb-8">
            <a href="{{ route('admin.dashboard') }}" class="mr-4 text-black hover:text-gray-600 transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-black tracking-wide">Pemesanan</h1>
        </div>

        <!-- Container Card Putih -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            
            <!-- Judul & Tombol Riwayat -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">Daftar Pemesanan</h2>
                <a href="{{ route('admin.pemesanan.riwayat') }}" class="bg-[#2F8540] hover:bg-[#246631] text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm">
                    Riwayat
                </a>
            </div>

            <!-- Tabel Pemesanan -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr class="bg-[#EAF3EA]">
                            <th class="py-4 px-6 font-semibold text-gray-800 rounded-l-xl w-16">No</th>
                            <th class="py-4 px-6 font-semibold text-gray-800">Nama</th>
                            <th class="py-4 px-6 font-semibold text-gray-800">No.Telepon</th>
                            <th class="py-4 px-6 font-semibold text-gray-800">Status Pemesanan</th>
                            <th class="py-4 px-6 font-semibold text-gray-800 rounded-r-xl"></th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($pemesanans as $index => $item)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-5 px-6 font-medium text-gray-700">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-5 px-6 text-gray-800">{{ $item->pelanggan->name }}</td>
                            <td class="py-5 px-6 text-gray-800">{{ $item->pelanggan->nomor_telpon }}</td>
                            <td class="py-5 px-6 text-center">
                                @php
                                    $statusClass = 'bg-gray-100 text-gray-700 border-gray-300';
                                    if(strtolower($item->status_pembayaran) == 'dikirim') {
                                        $statusClass = 'bg-blue-100 text-blue-700 border-blue-300';
                                    } elseif(strtolower($item->status_pembayaran) == 'diproses') {
                                        $statusClass = 'bg-orange-100 text-orange-600 border-orange-300 bg-orange-50/50';
                                    } elseif(strtolower($item->status_pembayaran) == 'menunggu konfirmasi' || strtolower($item->status_pembayaran) == 'menunggu verifikasi') {
                                        $statusClass = 'bg-red-100 text-red-600 border-red-300';
                                    }
                                @endphp
                                <div class="flex justify-center items-center w-full">
                                    <span class="inline-block px-5 py-1.5 border rounded-full text-[13px] font-semibold {{ $statusClass }}">
                                        {{ $item->status_pembayaran }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-5 px-6 text-right">
                                <a href="{{ route('admin.pemesanan.show', $item->id) }}" class="inline-block bg-[#2F8540] text-white px-5 py-2.5 rounded-lg text-[13px] font-bold hover:bg-[#246631] transition shadow-sm">
                                    Lihat Detail Pemesanan
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-gray-400 italic">Belum ada pemesanan aktif di SELADAKU.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection