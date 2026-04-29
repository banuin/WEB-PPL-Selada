@extends('layouts.app')

@section('content')

    <div class="hero-wrapper">
        <div class="hero-container">
            <div class="hero-bg">
                <img src="{{ asset('images/kebun-selada.jpg') }}" alt="Kebun" class="hero-img">
            </div>
            <div class="relative z-10 max-w-3xl">
                <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded mb-4 inline-block uppercase tracking-widest">Admin Mode</span>
                <h1 class="hero-title">Kenapa Selada Bisa Berwarna<br>Putih? Ini Penjelasannya!</h1>
                <p class="text-white text-sm font-medium mb-12 opacity-90">Mode Administrator: Kelola konten dan pantau pelanggan.</p>
                <a href="#" class="btn-white">Selengkapnya</a>
            </div>
        </div>
    </div>

    <div class="section-wrapper">
        <div class="section-header">
            <h2 class="section-title">Artikel</h2>
            <div class="section-line"></div>
        </div>

        <div class="grid-container">
            @php $articles = \App\Models\Artikel::latest()->get(); @endphp

            @if($articles->count() > 0)
                {{-- Tampilan jika SUDAH ADA data dari Admin --}}
                @foreach($articles as $item)
                <div class="card">
                    <img src="{{ asset('images/articles/'.$item->gambar) }}" alt="Gambar" class="card-img">
                    <h3 class="text-sm font-bold text-center text-black mb-4 px-2">{{ $item->judul }}</h3>
                    <a href="{{ route('artikel.show', $item->id) }}" 
                    class="w-full bg-[#2F8540] hover:bg-[#266d33] text-white font-semibold text-sm py-3 rounded-xl text-center transition shadow-sm block">
                        Selengkapnya
                    </a>
                </div>
                @endforeach
            @else
                {{-- Tampilan SEMENTARA (Placeholder) jika database masih kosong --}}
                @for ($i = 0; $i < 6; $i++)
                <div class="card">
                    <img src="{{ asset('images/menanam-selada.jpg') }}" alt="Petani" class="card-img">
                    <h3 class="text-sm font-bold text-center text-black mb-4 px-2 tracking-tight leading-snug">
                        Kenapa Selada Bisa Berwarna Putih? Ini Penjelasannya!   
                    </h3>
                    <a href="#" class="btn-primary mt-auto">Selengkapnya</a>
                </div>
                @endfor
            @endif
        </div>
    </div>

@endsection