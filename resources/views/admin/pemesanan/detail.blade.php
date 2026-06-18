@extends('layouts.app')

@section('content')

    <div x-data="{ showReceipt: false, showCancelModal: false, showDropdownModal: false, previousStatus: '{{ $pemesanan->status_pembayaran }}' }" class="max-w-6xl mx-auto px-4 py-8">
        
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.pemesanan.index') }}" class="text-gray-600 hover:text-gray-900 mr-4 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Detail Pemesanan</h1>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded-xl font-medium text-sm">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-6">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-lg font-bold text-gray-900">{{ $pemesanan->pelanggan->name }}</h3>
                <span class="text-sm text-gray-600 font-medium">{{ \Carbon\Carbon::parse($pemesanan->tanggal_pemesanan)->format('d/m/Y') }}</span>
            </div>
            <p class="text-sm text-gray-700 mb-1">{{ $pemesanan->pelanggan->nomor_telpon }}</p>
            <p class="text-sm text-gray-700">{{ $pemesanan->pelanggan->alamat }}</p>
        </div>

        @php 
            $detail = $pemesanan->detailPemesanan->first(); 
        @endphp

        <div class="flex flex-col md:flex-row gap-6">
            @if($detail && $detail->katalog)
                @php 
                    $katalog = $detail->katalog;
                    $fotoUtama = is_array($katalog->foto) ? $katalog->foto[0] : json_decode($katalog->foto)[0];
                @endphp

                <div class="w-full md:w-5/12 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-max">
                    <img src="{{ asset('storage/' . $fotoUtama) }}" alt="{{ $katalog->judul }}" class="w-full h-64 object-cover rounded-xl mb-4">
                    <h4 class="font-bold text-gray-900 text-lg mb-2">{{ $katalog->judul }}</h4>
                    <p class="text-[#2F8540] font-extrabold text-xl">Rp. {{ number_format($detail->harga_saat_pesan, 0, ',', '.') }}</p>
                </div>

                <div class="w-full md:w-7/12 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 flex flex-col justify-between">
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

                    <div class="mt-8">
                        <div class="flex items-center justify-between py-4 border-t border-gray-300">
                            <div class="w-1/3 text-sm text-gray-700 font-medium">Total Harga</div>
                            <div class="w-4 text-sm text-gray-700 text-center">:</div>
                            <div class="flex-1 flex items-center justify-end gap-3">
                                <span class="font-extrabold text-[#2F8540] text-xl">Rp. {{ number_format($pemesanan->total_pembayaran, 0, ',', '.') }}</span>
                                
                                <button type="button" @click="showReceipt = true" class="bg-[#3B82F6] hover:bg-blue-700 text-white text-xs font-semibold py-1.5 px-3 rounded flex items-center gap-1 transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Receipt
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="text-sm text-gray-700">Status Pemesanan</div>
                            
                            <div class="flex-1 flex justify-end gap-2 items-center">
                                @if(strtolower($pemesanan->status_pembayaran) == 'menunggu verifikasi' || strtolower($pemesanan->status_pembayaran) == 'menunggu konfirmasi')
                                    <form id="form-batalkan-admin" action="{{ route('admin.pemesanan.updateStatus', $pemesanan->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="Dibatalkan">
                                    </form>
                                    <button type="button" @click="showCancelModal = true" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg text-sm transition shadow-sm">
                                        Batalkan
                                    </button>
                                    <form action="{{ route('admin.pemesanan.updateStatus', $pemesanan->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="Diproses">
                                        <button type="submit" class="bg-[#16A34A] hover:bg-green-700 text-white font-semibold py-2 px-8 rounded-lg text-sm transition shadow-sm">
                                            Konfirmasi
                                        </button>
                                    </form>
                                @elseif(strtolower($pemesanan->status_pembayaran) == 'selesai')
                                    <span class="inline-block bg-green-100 text-green-700 border border-green-200 px-6 py-2 rounded-full text-xs font-bold tracking-wide shadow-sm">
                                        Selesai
                                    </span>
                                @elseif(strtolower($pemesanan->status_pembayaran) == 'dibatalkan')
                                    <span class="inline-block bg-red-100 text-red-700 border border-red-200 px-6 py-2 rounded-full text-xs font-bold tracking-wide shadow-sm">
                                        Dibatalkan
                                    </span>
                                @else
                                    <form id="form-status-dropdown" action="{{ route('admin.pemesanan.updateStatus', $pemesanan->id) }}" method="POST">
                                        @csrf
                                        <select name="status" 
                                                required 
                                                x-ref="statusSelect"
                                                @change="if($event.target.value === 'Dibatalkan') { showDropdownModal = true; } else { $event.target.form.submit(); }" 
                                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-[#2F8540] focus:border-[#2F8540] p-2.5 outline-none cursor-pointer font-medium text-gray-800 shadow-sm transition-all">
                                            <option value="Diproses" {{ $pemesanan->status_pembayaran == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="Dikirim" {{ $pemesanan->status_pembayaran == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                            <option value="Selesai" {{ $pemesanan->status_pembayaran == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="Dibatalkan" {{ $pemesanan->status_pembayaran == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="w-full bg-red-50 text-red-600 p-8 rounded-2xl text-center shadow-sm">
                    Rincian produk tidak ditemukan (kemungkinan data uji coba).
                </div>
            @endif
        </div>

        <div x-show="showReceipt" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center transition-opacity">
            
            <div @click="showReceipt = false" class="absolute inset-0 bg-white/40 backdrop-blur-sm cursor-pointer"></div>
            
            <div class="relative z-10 w-full max-w-sm mx-auto flex justify-center items-center p-4" x-transition.scale.origin.center>
                @if($pemesanan->bukti_transfer)
                    <div class="bg-black/20 backdrop-blur-md p-3 sm:p-6 rounded-[2rem] shadow-2xl flex justify-center items-center w-full">
                        <img src="{{ asset('storage/' . $pemesanan->bukti_transfer) }}" alt="Bukti Transfer" class="w-full h-auto max-h-[75vh] object-contain rounded-2xl shadow-sm bg-white">
                    </div>
                @else
                    <div class="bg-white p-8 rounded-2xl shadow-2xl text-center w-full">
                        <p class="text-gray-500 italic">Pelanggan tidak melampirkan bukti pembayaran.</p>
                    </div>
                @endif
            </div>

        </div>

        <!-- Cancel Modal (Button) -->
        <div x-show="showCancelModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity" @click="showCancelModal = false"></div>
            <div class="bg-white rounded-2xl shadow-2xl z-10 w-full max-w-sm mx-4 overflow-hidden transform transition-all" x-transition.scale.origin.center>
                <div class="p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Batalkan Pesanan?</h3>
                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin membatalkan pesanan ini? Stok akan dikembalikan otomatis.</p>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
                    <button type="button" @click="showCancelModal = false" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">
                        Kembali
                    </button>
                    <button type="button" onclick="document.getElementById('form-batalkan-admin').submit()" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition">
                        Ya, Batalkan
                    </button>
                </div>
            </div>
        </div>

        <!-- Dropdown Cancel Modal -->
        <div x-show="showDropdownModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity" @click="showDropdownModal = false; $refs.statusSelect.value = previousStatus;"></div>
            <div class="bg-white rounded-2xl shadow-2xl z-10 w-full max-w-sm mx-4 overflow-hidden transform transition-all" x-transition.scale.origin.center>
                <div class="p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Batalkan Pesanan?</h3>
                    <p class="text-sm text-gray-500 mb-2">Apakah Anda yakin membatalkan pesanan ini?</p>
                    <p class="text-sm font-semibold text-red-600">Pastikan uang dikembalikan ke pelanggan!</p>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
                    <button type="button" @click="showDropdownModal = false; $refs.statusSelect.value = previousStatus;" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">
                        Kembali
                    </button>
                    <button type="button" onclick="document.getElementById('form-status-dropdown').submit()" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition">
                        Ya, Batalkan
                    </button>
                </div>
            </div>
        </div>

    </div>

@endsection