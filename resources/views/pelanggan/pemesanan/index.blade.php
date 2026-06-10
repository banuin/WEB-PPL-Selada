@extends('layouts.app')

@section('content')

    <div class="max-w-6xl mx-auto px-4 py-8 relative">
        
        <div class="flex items-center mb-6">
            <a href="{{ route('pelanggan.home') }}" class="text-gray-600 hover:text-gray-900 mr-4 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Pemesanan</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">Daftar Pemesanan</h2>
                <a href="{{ route('pelanggan.pemesanan.riwayat') }}" class="bg-[#2F8540] hover:bg-green-800 text-white font-medium py-2 px-6 rounded-lg transition-colors text-sm shadow-sm">
                    Riwayat
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#E8F5E9] text-gray-800 text-sm border-b-2 border-white">
                            <th class="py-4 px-6 font-semibold rounded-l-xl">No</th>
                            <th class="py-4 px-6 font-semibold">Nama</th>
                            <th class="py-4 px-6 font-semibold">No.Telepon</th>
                            <th class="py-4 px-6 font-semibold text-center">Status Pemesanan</th>
                            <th class="py-4 px-6 font-semibold rounded-r-xl text-center">Aksi</th>
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
                                    $statusClass = 'bg-gray-100 text-gray-700 border-gray-300'; // default
                                    if(strtolower($item->status_pembayaran) == 'dikirim') {
                                        $statusClass = 'bg-blue-100 text-blue-700 border-blue-300';
                                    } elseif(strtolower($item->status_pembayaran) == 'diproses') {
                                        $statusClass = 'bg-orange-100 text-orange-600 border-orange-300';
                                    } elseif(strtolower($item->status_pembayaran) == 'menunggu konfirmasi' || strtolower($item->status_pembayaran) == 'menunggu verifikasi') {
                                        $statusClass = 'bg-red-100 text-red-600 border-red-300';
                                    }
                                @endphp
                                <span class="px-4 py-1.5 rounded-full border text-xs font-medium {{ $statusClass }}">
                                    {{ $item->status_pembayaran }}
                                </span>
                            </td>
                            <td class="py-5 px-6 text-center">
                                <a href="{{ route('pelanggan.pemesanan.show', $item->id) }}" class="inline-block bg-[#2F8540] hover:bg-green-800 text-white font-medium py-2 px-4 rounded-lg transition-colors text-xs shadow-sm">
                                    Lihat Detail Pemesanan
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-gray-400 italic">Belum ada pemesanan aktif.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection