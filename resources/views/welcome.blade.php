<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SELADAKU</title>

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
            
            <div class="hidden md:flex flex-1 justify-start gap-8">
                <a href="#" class="nav-link">Artikel</a>
                <a href="#" class="nav-link">Katalog</a>
            </div>

            <div class="flex-shrink-0 flex justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SELADAKU" class="h-8 md:h-10 w-auto object-contain">
            </div>

            <div class="hidden md:flex flex-1 justify-end items-center gap-6">
                <a href="{{ route('register') }}" class="nav-link">Daftar</a>
                <a href="{{ route('login') }}" class="px-5 py-2 bg-[#337C3E] text-white rounded-lg hover:bg-green-800 transition shadow-sm font-bold text-sm">Masuk</a>
            </div>

            <div class="md:hidden flex flex-1 justify-end">
                <button id="mobile-btn" class="text-gray-700 focus:outline-none">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 px-6 py-4 space-y-4 shadow-md absolute w-full left-0">
            <a href="#" class="block text-sm font-bold text-gray-700 hover:text-green-700">Artikel</a>
            <a href="#" class="block text-sm font-bold text-gray-700 hover:text-green-700">Katalog</a>
            <hr class="border-gray-200">
            <a href="{{ route('register') }}" class="block text-sm font-bold text-gray-700 hover:text-green-700">Daftar</a>
            <a href="{{ route('login') }}" class="block text-sm font-bold text-green-700">Masuk</a>
        </div>
    </nav>
    <div class="hero-wrapper">
        <div class="hero-container">
            <div class="hero-bg">
                <img src="{{ asset('images/kebun-selada.jpg') }}" alt="Kebun Selada" class="hero-img">
            </div>
            <div class="relative z-10 max-w-3xl">
                <h1 class="hero-title">Kenapa Selada Bisa Berwarna<br>Putih? Ini Penjelasannya!</h1>
                <p class="text-white text-sm font-medium mb-15 opacity-90">Kenapa Selada Bisa Berwarna Putih? Ini Penjelasannya!</p>
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
            @for ($i = 0; $i < 6; $i++)
            <div class="card">
                <img src="{{ asset('images/menanam-selada.jpg') }}" alt="Petani" class="card-img">
                <h3 class="text-sm font-bold text-center text-black mb-4 px-2">Kenapa Selada Bisa Berwarna Putih? Ini Penjelasannya!</h3>
                <a href="#" class="btn-primary mt-auto">Selengkapnya</a>
            </div>
            @endfor
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
            <div class="card">
                <img src="{{ asset('images/aset-selada.jpg') }}" alt="Selada" class="card-img">
                <h3 class="text-sm font-bold text-black mb-2">Selada Paket Reseler/Tengkulak (minim 10Kg)</h3>
                <p class="text-[#2F6B38] font-extrabold text-sm mb-4">Rp.000.000</p>
                <a href="#" class="btn-primary mt-auto">Pesan</a>
            </div>
            @endfor
        </div>
    </div>

    <footer class="footer-wrapper">
        <div class="footer-circle -top-16 -left-16 w-64 h-64"></div>
        <div class="footer-circle -top-12 -left-12 w-56 h-56"></div>
        <div class="footer-circle -top-8 -left-8 w-48 h-48"></div>
        
        <div class="absolute bottom-6 right-6 grid grid-cols-5 gap-3 opacity-30">
            @for ($i = 0; $i < 20; $i++)
                <div class="w-2 h-2 bg-white rounded-full"></div>
            @endfor
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('mobile-btn');
            const menu = document.getElementById('mobile-menu');
            
            // Logika: Jika tombol ditekan, sembunyikan/tampilkan menu
            btn.addEventListener('click', function () {
                menu.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>