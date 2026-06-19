@extends('layouts.app')

@push('styles')
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; }
    </style>
@endpush

@section('content')

    @php
        // 1. Tangkap berat dari URL (jika kosong, default ke 10KG)
        $beratPaket = request('berat', 10); 
        
        // 2. Hitung harga per paket (Harga dasar 1KG dikali Berat terpilih)
        $hargaPaket = $katalog->harga * $beratPaket;
        
        // 3. Hitung maksimal jumlah paket yang bisa dibeli berdasarkan sisa stok total
        // Contoh: Stok 25, Paket 20 -> Maksimal cuma bisa beli 1 paket.
        $maxQty = floor($katalog->stok / $beratPaket);
    @endphp

    <div class="max-w-5xl mx-auto px-4 py-8">

        <div class="flex items-center mb-6">
            <a href="{{ route('pelanggan.katalog.show', $katalog->id) }}" class="text-gray-600 hover:text-gray-900 mr-4 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Rincian Pemesanan</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-lg font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                <span class="text-sm text-gray-600 font-medium">{{ date('d/m/Y') }}</span>
            </div>
            <p class="text-sm text-gray-700 mb-1">{{ Auth::user()->nomor_telpon }}</p>
            <p class="text-sm text-gray-700">{{ Auth::user()->alamat }}</p>
        </div>

        <form action="{{ route('pelanggan.checkout.proses') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-6 relative">
            @csrf
            <input type="hidden" name="id_produk" value="{{ $katalog->id }}">
            
            <input type="hidden" name="berat" value="{{ $beratPaket }}">

            {{-- Kartu Produk (Kiri) --}}
            <div class="w-full md:w-1/3 bg-white rounded-2xl shadow-sm border border-gray-100 p-5 h-max">
                @php $fotoUtama = is_array($katalog->foto) ? $katalog->foto[0] : json_decode($katalog->foto)[0]; @endphp
                <img src="{{ asset('storage/' . $fotoUtama) }}" alt="{{ $katalog->judul }}" class="w-full h-48 object-cover rounded-xl mb-4">
                
                <h4 class="font-bold text-gray-900 text-[15px] leading-tight mb-1">{{ $katalog->judul }}</h4>
                <p class="text-xs font-semibold text-gray-500 mb-3 bg-gray-100 inline-block px-3 py-1 rounded-md">Ukuran: {{ $beratPaket }} KG</p>
                
                <p class="text-[#2F8540] font-extrabold text-lg">Rp. {{ number_format($hargaPaket, 0, ',', '.') }}</p>
            </div>

            {{-- Detail Pemesanan (Kanan) --}}
            <div class="w-full md:w-2/3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 flex flex-col justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-300 pb-3">Detail Pemesanan</h3>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-1/3 text-sm text-gray-700">Nama Produk</div>
                            <div class="w-4 text-sm text-gray-700 text-center">:</div>
                            <div class="flex-1 text-sm text-gray-900 text-right font-medium">{{ $katalog->judul }} (Paket {{ $beratPaket }}KG)</div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-1/3 text-sm text-gray-700">Metode Pengiriman</div>
                            <div class="w-4 text-sm text-gray-700 text-center">:</div>
                            <div class="flex-1 flex justify-end">
                                <select name="metode_pengiriman" required class="bg-gray-100 border border-gray-200 text-xs text-gray-600 font-medium rounded-md focus:ring-[#2F8540] p-2 w-full max-w-[200px] outline-none cursor-pointer">
                                    <option value="">Pilih Pengiriman</option>
                                    <option value="Ambil di Tempat">Ambil di Tempat (Gratis)</option>
                                    <option value="Diantar">Diantar Kurir (Hubungi Admin)</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-1/3 text-sm text-gray-700">Jumlah Paket</div>
                            <div class="w-4 text-sm text-gray-700 text-center">:</div>
                            <div class="flex-1 flex justify-end">
                                <div class="inline-flex items-center border border-gray-300 rounded-md overflow-hidden">
                                    <button type="button" id="btn-kurang" class="px-3 py-1 bg-white hover:bg-gray-100 text-gray-600 font-bold transition border-r border-gray-300 select-none">−</button>

                                    <input type="number" id="qty-input" name="jumlah" value="1" min="1" max="{{ $maxQty }}"
                                           class="w-12 text-center border-none focus:ring-0 text-sm py-1 font-bold bg-white p-0">

                                    <button type="button" id="btn-tambah" class="px-3 py-1 bg-white hover:bg-gray-100 text-gray-600 font-bold transition border-l border-gray-300 select-none">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-1/3 text-sm text-gray-700">Harga per Paket</div>
                            <div class="w-4 text-sm text-gray-700 text-center">:</div>
                            <div class="flex-1 text-sm text-gray-900 text-right">Rp. {{ number_format($hargaPaket, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-gray-300">
                    <div class="flex items-center mb-6">
                        <div class="w-1/3 text-sm text-gray-700 font-bold">Total Pembayaran</div>
                        <div class="w-4 text-sm text-gray-700 text-center">:</div>
                        <div id="total-display" class="flex-1 font-extrabold text-[#2F8540] text-xl text-right">
                            Rp. {{ number_format($hargaPaket, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" onclick="document.getElementById('modal-bayar').style.display='flex'"
                                class="bg-[#16A34A] hover:bg-green-700 text-white font-bold py-3 px-10 rounded-xl transition-colors shadow-md text-sm">
                            Bayar
                        </button>
                    </div>
                </div>
            </div>

            {{-- Modal Pembayaran (Desain Interaktif yang sudah kita buat sebelumnya) --}}
            <div id="modal-bayar"
                 style="display: none;"
                 class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 backdrop-blur-[2px] transition-opacity"
                 onclick="if(event.target===this) tutupModal()">

                <div x-data="{ fileName: '' }" class="bg-white rounded-[2rem] shadow-2xl w-full max-w-sm p-8 mx-4 transform transition-all relative">
                    
                    <h3 class="text-xl font-extrabold text-center text-gray-900 mb-6">Pembayaran</h3>

                    <div class="border border-gray-200 rounded-xl p-3.5 flex justify-between items-center mb-4 shadow-sm bg-white">
                        <span class="text-sm font-bold text-gray-900">No.rekening BRI</span>
                        <span class="text-sm font-medium text-gray-600">0443456789102</span>
                    </div>

                    <div class="mb-6 relative">
                        <label class="flex items-center w-full border border-gray-200 rounded-xl p-3 cursor-pointer hover:bg-gray-50 transition shadow-sm bg-white overflow-hidden">
                            
                            <div x-show="fileName === ''" class="flex items-center justify-between w-full">
                                <div class="bg-[#E5E7EB] border border-gray-400 text-gray-700 text-xs font-semibold py-1.5 px-4 rounded-md shadow-sm">
                                    Pilih File
                                </div>
                                <span class="text-sm font-bold text-gray-900">Upload Bukti Transfer</span>
                            </div>

                            <div x-show="fileName !== ''" style="display: none;" class="flex items-center gap-3 w-full">
                                <div class="w-6 h-6 bg-[#388E3C] rounded-md flex-shrink-0 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-sm font-bold text-gray-900 truncate" x-text="fileName"></span>
                            </div>
                            
                            <input type="file" name="bukti_transfer" accept="image/*"
                                   class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"
                                   @change="fileName = $event.target.files[0].name" required>
                        </label>
                    </div>

                    <button type="submit" 
                            :class="fileName === '' ? 'bg-[#9CA3AF] cursor-not-allowed' : 'bg-[#2F8540] hover:bg-green-800'"
                            :disabled="fileName === ''"
                            class="w-full text-white font-bold py-3.5 rounded-xl transition-colors shadow-md text-sm">
                        Konfirmasi Pembayaran
                    </button>
                </div>
            </div>

        </form>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const HARGA_PAKET = {{ $hargaPaket }};
        const MAX_QTY = {{ $maxQty }};

        const qtyInput = document.querySelector('[name="jumlah"]');
        const totalEl  = document.getElementById('total-display');

        if (!qtyInput) return;

        function clamp(v) {
            v = parseInt(v);
            if (isNaN(v) || v < 1) return 1;
            return v > MAX_QTY ? MAX_QTY : v; 
        }

        window.tutupModal = function() {
            document.getElementById('modal-bayar').style.display = 'none';
        };

        function refreshTotal() {
            const v = clamp(qtyInput.value);
            qtyInput.value = v;
            if (totalEl) totalEl.textContent = 'Rp. ' + (v * HARGA_PAKET).toLocaleString('id-ID');
        }

        document.addEventListener('click', function (e) {
            if (e.target.id === 'btn-kurang' || e.target.closest('#btn-kurang')) {
                qtyInput.value = clamp(qtyInput.value) - 1;
                refreshTotal();
            }
            if (e.target.id === 'btn-tambah' || e.target.closest('#btn-tambah')) {
                qtyInput.value = clamp(qtyInput.value) + 1;
                refreshTotal();
            }
        });

        qtyInput.addEventListener('input', refreshTotal);
        qtyInput.addEventListener('blur',  refreshTotal);
    });
    </script>
    @endpush
@endsection