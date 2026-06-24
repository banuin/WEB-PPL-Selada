@extends('layouts.app')

@section('content')

    <div class="hero-wrapper">
        <div class="hero-container">
            <div class="hero-bg">
                <img src="{{ asset('images/kebun-selada.jpg') }}" alt="Kebun" class="hero-img">
            </div>
            <div class="relative z-10 max-w-3xl animate-on-scroll">
                <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded mb-4 inline-block uppercase tracking-widest">Admin Mode</span>
                <h1 class="hero-title">Kenapa Selada Bisa Berwarna<br>Putih? Ini Penjelasannya!</h1>
                <p class="text-white text-sm font-medium mb-12 opacity-90">Mode Administrator: Kelola konten dan pantau pelanggan.</p>
                <a href="#" class="btn-white">Selengkapnya</a>
            </div>
        </div>
    </div>

    <div class="section-wrapper !mb-24 margin-bottom: 80px;">
        <div class="section-header animate-on-scroll">
            <h2 class="section-title">Artikel</h2>
            <div class="section-line"></div>
        </div>

        <div class="grid-container">
            @php $articles = \App\Models\Artikel::latest()->get(); @endphp

            @if($articles->count() > 0)
                {{-- Tampilan jika SUDAH ADA data dari Admin --}}
                @foreach($articles as $item)
                <div class="card animate-on-scroll bg-white/90 backdrop-blur-sm">
                    <img src="{{ asset('images/articles/'.$item->gambar) }}" alt="Gambar" class="card-img">
                    <h3 class="text-sm font-bold text-center text-black mb-4 px-2">{{ $item->judul }}</h3>
                    <a href="{{ route('artikel.show', $item->id) }}" 
                    class="flex-full bg-[#2F8540] hover:bg-[#266d33] text-white font-semibold text-sm py-3 rounded-xl text-center transition shadow-sm block">
                        Selengkapnya
                    </a>
                </div>
                @endforeach
            @else
                {{-- Tampilan SEMENTARA (Placeholder) jika database masih kosong --}}
                @for ($i = 0; $i < 6; $i++)
                <div class="card animate-on-scroll bg-white/90 backdrop-blur-sm">
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

    <!-- ================= BAGIAN KATALOG ================= -->
    <div class="section-wrapper !mb-24">
        
        <!-- Header Katalog (Biar sama dengan Artikel) -->
        <div class="section-header animate-on-scroll">
            <h2 class="section-title">Katalog Terbaru</h2>
            <div class="section-line"></div>
        </div>

        <!-- Grid Katalog -->
        <!-- Tambahan max-w-5xl dan mx-auto biar sejajar persis dengan atasnya -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto w-full">
            
            @forelse ($katalogs as $item)
            <a href="{{ route('admin.katalog.show', $item->id) }}" class="bg-white/90 backdrop-blur-sm p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full hover:shadow-lg transition-all group text-left animate-on-scroll">
                
                <!-- Foto Katalog -->
                <div class="w-full h-48 overflow-hidden rounded-xl mb-5">
                    <img src="{{ asset('storage/' . $item->foto[0]) }}" 
                        alt="{{ $item->judul }}" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>

                <!-- Info Katalog -->
                <h3 class="text-[15px] font-bold text-gray-800 leading-snug mb-2 pr-4">
                    {{ $item->judul }}<br>
                    <!-- <span class="text-xs text-gray-500 font-medium">({{ $item->berat }}Kg)</span> -->
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
    <!-- ================= AKHIR BAGIAN KATALOG ================= -->

@endsection