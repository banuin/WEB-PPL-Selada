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

    <div id="artikel-section" class="section-wrapper">
        <div class="section-header">
            <h2 class="section-title">Artikel</h2>
            <div class="section-line"></div>
        </div>
        
        <div class="grid-container">
            {{-- Logika: Cek apakah ada artikel di database --}}
            @php $articles = \App\Models\Artikel::latest()->get(); @endphp

            @if($articles->count() > 0)
                @foreach($articles as $item)
                <div class="card flex flex-col h-full">
                    <img src="{{ asset('images/articles/'.$item->gambar) }}" alt="Gambar" class="card-img object-cover h-48 w-full">
                    <h3 class="text-sm font-bold text-center text-black mb-4 px-2 mt-4">{{ $item->judul }}</h3>
                    <a href="{{ route('artikel.show', $item->id) }}" 
                    class="w-full bg-[#2F8540] hover:bg-[#266d33] text-white font-semibold text-sm py-3 rounded-xl text-center transition shadow-sm block mt-auto">
                        Selengkapnya
                    </a>
                </div>
                @endforeach
            @else
                @for ($i = 0; $i < 6; $i++)
                <div class="card flex flex-col h-full">
                    <img src="{{ asset('images/menanam-selada.jpg') }}" alt="Petani" class="card-img object-cover h-48 w-full">
                    <h3 class="text-sm font-bold text-center text-black mb-4 px-2 mt-4 tracking-tight leading-snug">
                        Kenapa Selada Bisa Berwarna Putih? Ini Penjelasannya!   
                    </h3>
                    <a href="#" class="btn-primary mt-auto">Selengkapnya</a>
                </div>
                @endfor
            @endif
        </div>
        
        <div class="text-center mt-10">
            <a href="#" class="btn-outline">Lihat Lebih Banyak Lagi</a>
        </div>
    </div>

    <div class="section-wrapper">
        <div class="section-header">
            <h2 class="section-title">Katalog</h2>
            <div class="section-line"></div>
        </div>
        <div class="grid-container">
            @for ($i = 0; $i < 3; $i++)
            <div class="card flex flex-col h-full">
                <img src="{{ asset('images/aset-selada.jpg') }}" alt="Selada" class="card-img object-cover h-48 w-full">
                <h3 class="text-sm font-bold text-black mb-2 mt-4">Selada Paket Reseler/Tengkulak (minim 10Kg)</h3>
                <p class="text-[#2F6B38] font-extrabold text-sm mb-4">Rp.000.000</p>
                <a href="#" class="btn-primary mt-auto">Pesan</a>
            </div>
            @endfor
        </div>
    </div>

@endsection