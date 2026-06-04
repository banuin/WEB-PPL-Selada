@extends('layouts.app')

@section('content')

    <div class="hero-wrapper">
        <div class="hero-container">
            <div class="hero-bg"><img src="{{ asset('images/kebun-selada.jpg') }}" alt="Kebun" class="hero-img"></div>
            <div class="relative z-10 max-w-3xl">
                <h1 class="hero-title">Kenapa Selada Bisa Berwarna<br>Putih? Ini Penjelasannya!</h1>
                <p class="text-white text-sm mb-12 opacity-90">Kenapa Selada Bisa Berwarna Putih? Ini Penjelasannya!</p>
                <a href="#" class="btn-white">Selengkapnya</a>
            </div>
        </div>
    </div>

    <!-- <div id="artikel-section" class="section-wrapper"> -->
        <div class="section-header">
            <h2 class="section-title">Artikel</h2>
            <div class="section-line"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto w-full px-4">
            {{-- Logika: Cek apakah ada artikel di database --}}
            @php $articles = \App\Models\Artikel::latest()->get(); @endphp

            @if($articles->count() > 0)
                @foreach($articles as $item)
                <div class="card">
                    <img src="{{ asset('images/articles/'.$item->gambar) }}" alt="Gambar" class="card-img">
                    <h3 class="text-sm font-bold text-center text-black mb-4 px-2">{{ $item->judul }}</h3>
                    <a href="{{ route('artikel.show', $item->id) }}" 
                    class="flex-full bg-[#2F8540] hover:bg-[#266d33] text-white font-semibold text-sm py-3 rounded-xl text-center transition shadow-sm block">
                        Selengkapnya
                    </a>
                </div>
                @endforeach
            @else
                @for ($i = 0; $i < 3; $i++)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-md transition">
                    <img src="{{ asset('images/menanam-selada.jpg') }}" alt="Petani" class="w-full h-48 object-cover">
                    
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="text-[15px] font-bold text-gray-800 leading-snug mb-4 text-center">
                            Kenapa Selada Bisa Berwarna Putih? Ini Penjelasannya!   
                        </h3>
                        <a href="#" class="mt-auto w-full bg-[#2F8540] hover:bg-green-800 text-white font-semibold text-sm py-2.5 rounded-xl text-center transition shadow-sm block">
                            Selengkapnya
                        </a>
                    </div>
                </div>
                @endfor
            @endif
        </div>
        
        <div class="text-center mt-10">
            <a href="#" class="btn-outline">Lihat Lebih Banyak Lagi</a>
        </div>
    </div>  

       <!-- ================= BAGIAN KATALOG ================= -->
    <div class="section-wrapper !mb-24">
        
        <!-- Header Katalog (Biar sama dengan Artikel) -->
        <div class="section-header">
            <h2 class="section-title">Katalog Terbaru</h2>
            <div class="section-line"></div>
        </div>

        <!-- Grid Katalog -->
        <!-- Tambahan max-w-5xl dan mx-auto biar sejajar persis dengan atasnya -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto w-full">
            
            @forelse ($katalogs as $item)
            <a href="{{ route('pelanggan.katalog.show', $item->id) }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full hover:shadow-md transition group text-left">
                
                <!-- Foto Katalog -->
                <div class="w-full h-48 overflow-hidden rounded-xl mb-5">
                    <img src="{{ asset('storage/' . $item->foto[0]) }}" 
                        alt="{{ $item->judul }}" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>

                <!-- Info Katalog -->
                <h3 class="text-[15px] font-bold text-gray-800 leading-snug mb-2 pr-4">
                    {{ $item->judul }}<br>
                    <!-- <span class="text-xs text-gray-500 font-medium">(minim {{ $item->berat }}Kg)</span> -->
                </h3>

                <!-- Harga -->
                <p class="text-[#2F8540] font-bold text-[15px] mt-auto">
                    Rp{{ number_format($item->harga, 0, ',', '.') }}
                </p>
            </a>
            
            @empty
            <div class="col-span-full py-10 text-center">
                <p class="text-gray-400 italic">Katalog belum tersedia.</p>
            </div>
            @endforelse

        </div>

    </div>

@endsection