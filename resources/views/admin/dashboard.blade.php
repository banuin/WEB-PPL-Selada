<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - SELADAKU</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAFAFA] font-sans antialiased text-gray-800">

    <nav class="navbar">
        <div class="flex gap-8 w-1/3">
            <a href="#" class="nav-link">Artikel</a>
            <a href="#" class="nav-link">Katalog</a>
        </div>
        
        <div class="flex-shrink-0 flex justify-center w-1/3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 md:h-10 w-auto object-contain">
        </div>

        <div class="flex items-center justify-end w-1/3 relative group">
            <button class="text-gray-700 focus:outline-none p-2 border border-gray-100 rounded-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <div class="hidden group-hover:block absolute top-12 right-0 w-52 bg-white shadow-xl rounded-lg py-2 border border-gray-100 z-50">
                <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
                    <svg class="w-4 h-4 mr-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profil
                </a>

                <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition border-t border-gray-50">
                    <svg class="w-4 h-4 mr-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"></path></svg>
                    Profil Pelanggan
                </a>

                <hr class="my-1 border-gray-50">
                
                <a href="{{ route('welcome') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition">
                    <svg class="w-4 h-4 mr-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </a>
            </div>
        </div>
    </nav>

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
            @for ($i = 0; $i < 6; $i++)
            <div class="card">
                <img src="{{ asset('images/menanam-selada.jpg') }}" alt="Petani" class="card-img">
                <h3 class="text-sm font-bold text-center text-black mb-4 px-2 tracking-tight leading-snug">Kenapa Selada Bisa Berwarna Putih? Ini Penjelasannya!</h3>
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

</body>
</html>