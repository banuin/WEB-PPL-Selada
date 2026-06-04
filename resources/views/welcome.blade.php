<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SELADAKU - Beranda</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-[#FAFAFA] font-sans antialiased text-gray-800">

    <nav class="w-full bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Seladaku" class="h-8 w-auto">
                <span class="font-extrabold text-xl text-[#2F8540] tracking-wide">Seladaku</span>
            </div>

            <div class="hidden md:flex flex-1 justify-center gap-8">
                <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 hover:text-[#2F8540] transition">Artikel</a>
                <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 hover:text-[#2F8540] transition">Katalog</a>
            </div>

            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('register') }}" class="text-sm font-bold text-gray-700 hover:text-[#2F8540] transition">Daftar</a>
                <a href="{{ route('login') }}" class="px-6 py-2.5 bg-[#2F8540] text-white rounded-lg hover:bg-green-800 transition shadow-sm font-bold text-sm">Masuk</a>
            </div>

            <div class="md:hidden flex items-center">
                <button id="mobile-btn" class="text-gray-700 focus:outline-none">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 px-6 py-4 space-y-4 shadow-md absolute w-full left-0">
            <a href="{{ route('login') }}" class="block text-sm font-bold text-gray-700 hover:text-[#2F8540]">Artikel</a>
            <a href="{{ route('login') }}" class="block text-sm font-bold text-gray-700 hover:text-[#2F8540]">Katalog</a>
            <hr class="border-gray-200">
            <a href="{{ route('register') }}" class="block text-sm font-bold text-gray-700 hover:text-[#2F8540]">Daftar</a>
            <a href="{{ route('login') }}" class="block text-sm font-bold text-[#2F8540]">Masuk</a>
        </div>
    </nav>

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

    <div class="mt-12">
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

    <div class="section-wrapper !mb-24 mt-16">
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

    <footer class="bg-gray-900 relative overflow-hidden py-12 mt-10">
        <div class="absolute -top-16 -left-16 w-64 h-64 border-4 border-gray-800 rounded-full opacity-50"></div>
        <div class="absolute -top-12 -left-12 w-56 h-56 border-4 border-gray-800 rounded-full opacity-50"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h3 class="text-2xl font-extrabold text-white mb-2 tracking-wide">SELADAKU</h3>
            <p class="text-gray-400 text-sm font-medium">Sayuran segar langsung dari kebun, untuk gaya hidup sehat Anda.</p>
        </div>
        
        <div class="absolute bottom-6 right-6 grid grid-cols-5 gap-3 opacity-20">
            @for ($i = 0; $i < 20; $i++)
                <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
            @endfor
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('mobile-btn');
            const menu = document.getElementById('mobile-menu');
            
            btn.addEventListener('click', function () {
                menu.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>