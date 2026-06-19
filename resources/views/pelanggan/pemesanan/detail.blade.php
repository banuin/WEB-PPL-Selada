@extends('layouts.app')

@section('content')

    <div x-data="{ showSuccess: {{ session('success_payment') ? 'true' : 'false' }}, showCancelModal: false }" class="max-w-5xl mx-auto px-4 py-8">

        <div class="flex items-center mb-6">
            <a href="{{ route('pelanggan.pemesanan.index') }}" class="text-gray-600 hover:text-gray-900 mr-4 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Rincian Pemesanan</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-lg font-bold text-gray-900">{{ $pemesanan->pelanggan->name }}</h3>
                <span class="text-sm text-gray-600 font-medium">{{ \Carbon\Carbon::parse($pemesanan->tanggal_pemesanan)->format('d/m/Y') }}</span>
            </div>
            <p class="text-sm text-gray-700 mb-1">{{ $pemesanan->pelanggan->nomor_telpon }}</p>
            <p class="text-sm text-gray-700">{{ $pemesanan->pelanggan->alamat }}</p>
        </div>

        @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl relative text-sm font-medium">
            {{ session('error') }}
        </div>
        @endif

        <div class="flex flex-col md:flex-row gap-6 relative">
            @php
                // Mengambil data relasi
                $detail = $pemesanan->detailPemesanan->first();
            @endphp

            @if($detail && $detail->katalog)
                @php
                    $katalog = $detail->katalog;
                    $fotoUtama = is_array($katalog->foto) ? $katalog->foto[0] : json_decode($katalog->foto)[0];
                @endphp

                <div class="w-full md:w-1/3 bg-white rounded-2xl shadow-sm border border-gray-100 p-5 h-max">
                    <img src="{{ asset('storage/' . $fotoUtama) }}" alt="{{ $katalog->judul }}" class="w-full h-48 object-cover rounded-xl mb-4">
                    <h4 class="font-bold text-gray-900 text-[15px] leading-tight mb-2">{{ $katalog->judul }}</h4>
                    <p class="text-[#2F8540] font-extrabold text-lg">Rp. {{ number_format($detail->harga_saat_pesan, 0, ',', '.') }}</p>
                </div>

                <div class="w-full md:w-2/3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 flex flex-col justify-between">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-300 pb-3">Detail Pemesanan</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="w-1/3 text-sm text-gray-700">Nama Produk</div>
                                <div class="w-4 text-sm text-gray-700 text-center">:</div>
                                <div class="flex-1 text-sm text-gray-900 text-right">{{ $katalog->judul }}</div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-1/3 text-sm text-gray-700">Metode Pengiriman</div>
                                <div class="w-4 text-sm text-gray-700 text-center">:</div>
                                <div class="flex-1 text-sm text-gray-900 text-right">{{ $pemesanan->metode_pengiriman }}</div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-1/3 text-sm text-gray-700">Jumlah Produk</div>
                                <div class="w-4 text-sm text-gray-700 text-center">:</div>
                                <div class="flex-1 text-sm text-gray-900 text-right">{{ $detail->jumlah }}</div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-1/3 text-sm text-gray-700">Harga Produk</div>
                                <div class="w-4 text-sm text-gray-700 text-center">:</div>
                                <div class="flex-1 text-sm text-gray-900 text-right">Rp. {{ number_format($detail->harga_saat_pesan, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-4 border-t border-gray-300">
                        <div class="flex items-center mb-6">
                            <div class="w-1/3 text-sm text-gray-700">Total Harga</div>
                            <div class="w-4 text-sm text-gray-700 text-center">:</div>
                            <div class="flex-1 font-bold text-[#2F8540] text-xl text-right">
                                Rp. {{ number_format($pemesanan->total_pembayaran, 0, ',', '.') }}
                            </div>
                        </div>
                        
                        <div class="flex items-center pt-2 border-t border-gray-100">
                            <div class="w-1/2 text-sm text-gray-700">Status Pesanan</div>
                            <div class="w-1/2 flex justify-end gap-2 items-center">
                                @php
                                    $isCancellable = !in_array(strtolower($pemesanan->status_pembayaran), ['diproses', 'dikirim', 'selesai', 'dibatalkan']);
                                    $statusClass = 'bg-gray-200 text-gray-700 border-gray-300';
                                    if(strtolower($pemesanan->status_pembayaran) == 'dibatalkan') {
                                        $statusClass = 'bg-red-200 text-red-700 border-red-300';
                                    } elseif(strtolower($pemesanan->status_pembayaran) == 'selesai') {
                                        $statusClass = 'bg-green-200 text-green-700 border-green-300';
                                    } elseif(strtolower($pemesanan->status_pembayaran) == 'dikirim') {
                                        $statusClass = 'bg-blue-200 text-blue-700 border-blue-300';
                                    } elseif(strtolower($pemesanan->status_pembayaran) == 'diproses') {
                                        $statusClass = 'bg-orange-200 text-orange-700 border-orange-300';
                                    } else {
                                        $statusClass = 'bg-yellow-200 text-yellow-700 border-yellow-300';
                                    }
                                @endphp
                                <span class="{{ $statusClass }} border px-5 py-2 rounded-full text-xs font-semibold tracking-wide">
                                    {{ $pemesanan->status_pembayaran }}
                                </span>
                                @if($isCancellable)
                                    <form id="form-batalkan-pelanggan" action="{{ route('pelanggan.pemesanan.batalkan', $pemesanan->id) }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                    <!-- <button type="button" @click="showCancelModal = true" class="bg-red-600 hover:bg-red-700 text-white border border-red-700 px-4 py-2 rounded-full text-xs font-semibold tracking-wide transition shadow-sm whitespace-nowrap">
                                        Batalkan Pesanan
                                    </button> -->
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="w-full bg-red-50 border-2 border-red-200 text-red-600 p-8 rounded-2xl text-center shadow-sm">
                    <svg class="w-16 h-16 mx-auto mb-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <h3 class="text-xl font-bold mb-2">Rincian Produk Tidak Ditemukan</h3>
                    <p class="text-sm">Data pemesanan ini tidak memiliki rincian produk (kemungkinan data uji coba lama). Silakan hapus data ini melalui database.</p>
                </div>
            @endif
        </div>

        <div x-show="showSuccess"
             x-init="if(showSuccess) setTimeout(() => showSuccess = false, 2500)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90"
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center pointer-events-none">
            
            <div class="bg-[#16A34A] text-white font-bold py-3.5 px-8 rounded-full shadow-2xl text-lg tracking-wide flex items-center gap-3 pointer-events-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Pembayaran Berhasil
            </div>
        </div>

        <!-- Cancel Modal -->
        <div x-show="showCancelModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity" @click="showCancelModal = false"></div>
            <div class="bg-white rounded-2xl shadow-2xl z-10 w-full max-w-sm mx-4 overflow-hidden transform transition-all" x-transition.scale.origin.center>
                <div class="p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Batalkan Pesanan?</h3>
                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
                    <button type="button" @click="showCancelModal = false" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">
                        Kembali
                    </button>
                    <button type="button" onclick="document.getElementById('form-batalkan-pelanggan').submit()" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition">
                        Ya, Batalkan
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection