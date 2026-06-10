@extends('layouts.app')

@section('content')

    <div class="max-w-5xl mx-auto px-4 py-8"
         x-data="{
             stok: {{ $produk->stok }},
             hargaDasar: {{ $produk->harga }},
             // Jika stok < 10, set default 0. Jika ada, set default 10
             beratTerpilih: {{ $produk->stok >= 10 ? 10 : 0 }},
             gambarUtama: '{{ asset('storage/' . $produk->foto[0]) }}',
             
             // Fungsi format rupiah
             formatRupiah(angka) {
                 return new Intl.NumberFormat('id-ID').format(angka);
             }
         }">
         
        <a href="{{ route('pelanggan.home') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6 transition font-medium">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 flex flex-col md:flex-row gap-8">
            
            <div class="w-full md:w-1/2">
                <img :src="gambarUtama" alt="{{ $produk->judul }}" class="w-full h-80 object-cover rounded-xl mb-4 transition-all duration-300 shadow-sm border border-gray-100">
                
                <div class="flex gap-3">
                    @foreach($produk->foto as $gambar)
                        <img src="{{ asset('storage/' . $gambar) }}" 
                             @click="gambarUtama = '{{ asset('storage/' . $gambar) }}'"
                             :class="gambarUtama === '{{ asset('storage/' . $gambar) }}' ? 'border-[#2F8540] opacity-100' : 'border-transparent opacity-60 hover:opacity-100'"
                             class="w-20 h-20 object-cover rounded-lg border-2 cursor-pointer transition-all duration-200">
                    @endforeach
                </div>
            </div>

            <div class="w-full md:w-1/2 flex flex-col justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-4">{{ $produk->judul }}</h1>
                    <p class="text-gray-600 text-[15px] leading-relaxed mb-6">
                        {{ $produk->deskripsi }}
                    </p>

                    <div class="mb-6">
                        <span class="block text-sm font-bold text-gray-700 mb-3">Pilih Paket Berat:</span>
                        <div class="flex flex-wrap gap-3">
                            <template x-for="b in [10, 20, 30, 40, 50]" :key="b">
                                <button type="button"
                                    @click="if(stok >= b) beratTerpilih = b"
                                    :disabled="stok < b"
                                    :class="{
                                        'bg-[#2F8540] text-white shadow-md border-transparent': beratTerpilih === b,
                                        'bg-white text-gray-700 border-gray-300 hover:border-[#2F8540] hover:text-[#2F8540]': beratTerpilih !== b && stok >= b,
                                        'bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed': stok < b
                                    }"
                                    class="px-5 py-2 text-sm font-bold rounded-full border transition-all"
                                    x-text="b + 'KG'">
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div>
                            <span class="block text-sm font-bold text-gray-700 mb-2">Total Stok:</span>
                            <div class="px-4 py-3 border border-gray-300 rounded-lg text-gray-800 font-bold text-center bg-gray-50">
                                {{ $produk->stok }} KG
                            </div>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-gray-700 mb-2">Total Harga:</span>
                            <div class="px-4 py-3 border border-[#2F8540] bg-green-50/50 rounded-lg text-[#2F8540] font-extrabold text-center tracking-wide"
                                 x-text="'Rp ' + formatRupiah(hargaDasar * (beratTerpilih > 0 ? beratTerpilih : 1))">
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <a x-show="stok >= 10" 
                       :href="'{{ route('pelanggan.checkout', $produk->id) }}?berat=' + beratTerpilih" 
                       class="block w-full bg-[#2F8540] hover:bg-green-800 text-white text-center font-bold py-4 rounded-xl transition-colors shadow-md text-lg">
                        Pesan sekarang (<span x-text="beratTerpilih + 'KG'"></span>)
                    </a>
                    
                    <button type="button" 
                            x-show="stok < 10" 
                            disabled 
                            class="block w-full bg-gray-400 text-white text-center font-bold py-4 rounded-xl cursor-not-allowed text-lg">
                        Stok Tidak Mencukupi
                    </button>
                </div>
            </div>

        </div>
    </div>

@endsection