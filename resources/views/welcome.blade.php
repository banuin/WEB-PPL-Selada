@extends('layouts.app')

@section('title', 'SELADAKU - Beranda')

@section('content')

    <div class="hero-wrapper mt-4">
        <div class="hero-container">
            <div class="hero-bg"><img src="{{ asset('images/kebun-selada.jpg') }}" alt="Kebun" class="hero-img"></div>
            <div class="relative z-10 max-w-3xl">
                <h1 class="hero-title">Kenapa Selada Bisa Berwarna<br>Putih? Ini Penjelasannya!</h1>
                <p class="text-white text-sm mb-12 opacity-90">Kenapa Selada Bisa Berwarna Putih? Ini Penjelasannya!</p>
                <a href="{{ route('login') }}" class="btn-white">Selengkapnya</a>
            </div>
        </div>
    </div>

    <div class="mt-12" id="artikel-section">
        <div class="section-header">
            <h2 class="section-title">Artikel</h2>
            <div class="section-line"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto w-full px-4">
            @forelse ($artikels as $item)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-md transition">
                <img src="{{ asset('images/articles/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                
                <div class="p-5 flex flex-col flex-grow">
                    <h3 class="text-[15px] font-bold text-gray-800 leading-snug mb-4 text-center">
                        {{ $item->judul }}
                    </h3>
                    <a href="{{ route('login') }}" class="mt-auto w-full bg-[#2F8540] hover:bg-green-800 text-white font-semibold text-sm py-2.5 rounded-xl text-center transition shadow-sm block">
                        Selengkapnya
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-10 text-center">
                <p class="text-gray-400 italic">Artikel belum tersedia.</p>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-10">
            <a href="{{ route('login') }}" class="btn-outline">Lihat Lebih Banyak Lagi</a>
        </div>
    </div>  

    <div class="section-wrapper !mb-24 mt-16" id="katalog-section">
        <div class="section-header">
            <h2 class="section-title">Katalog Terbaru</h2>
            <div class="section-line"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto w-full px-4">
            @forelse ($katalogs as $item)
            <a href="{{ route('login') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full hover:shadow-md transition group text-left">
                
                <div class="w-full h-48 overflow-hidden rounded-xl mb-5">
                    @php
                        // Cek apakah foto berbentuk array/JSON atau string biasa
                        $foto = is_array($item->foto) ? $item->foto[0] : (json_decode($item->foto)[0] ?? $item->foto);
                    @endphp
                    <img src="{{ asset('storage/' . $foto) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>

                <h3 class="text-[15px] font-bold text-gray-800 leading-snug mb-2 pr-4">
                    {{ $item->judul }}
                </h3>

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