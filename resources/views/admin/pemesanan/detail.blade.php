<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pemesanan - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#FAFAFA] font-sans antialiased text-gray-800 p-8 md:p-12 min-h-screen">

    <div class="max-w-5xl mx-auto">
        
        <!-- Header Halaman (Panah Kembali & Judul) -->
        <div class="flex items-center mb-8">
            <a href="{{ route('admin.pemesanan.index') }}" class="mr-4 text-black hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-black tracking-wide">Detail Pemesanan</h1>
        </div>

        <!-- Card Atas: Info Pelanggan (Ditambahkan Tanggal di Kanan) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex justify-between items-start mb-3">
                <h2 class="text-[18px] font-bold text-black">Shinta Bella</h2>
                <span class="text-[14px] text-gray-800 font-medium">05/05/2026</span>
            </div>
            <p class="text-[14px] text-gray-800 mb-2 font-medium">085123456789</p>
            <p class="text-[14px] text-gray-800 font-medium">Tegal Besar, Kec. Kaliwates, Kabupaten Jember, Jawa Timur 68131</p>
        </div>

        <!-- Grid 2 Kolom untuk Info Produk & Rincian Harga -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            
            <!-- KOLOM KIRI: INFO PRODUK -->
            <div class="col-span-1 md:col-span-5 bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
                <div class="w-full aspect-square rounded-xl overflow-hidden mb-5">
                    <img src="{{ asset('images/aset-selada.jpg') }}" alt="Selada" class="w-full h-full object-cover">
                </div>
                <h3 class="text-[16px] font-bold text-black leading-snug mb-3">
                    Selada Paket Reseler/Tengkulak<br>(minim 10Kg)
                </h3>
                <p class="text-xl font-bold text-[#2F8540] mt-auto">Rp. 200.000</p>
            </div>

            <!-- KOLOM KANAN: RINCIAN HARGA & STATUS -->
            <div class="col-span-1 md:col-span-7 bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
                <h3 class="text-[15px] font-bold text-black border-b border-gray-200 pb-4 mb-5">Detail Pemesanan</h3>
                
                <!-- Daftar Rincian -->
                <div class="flex flex-col gap-4 mb-6">
                    <div class="flex items-start">
                        <span class="w-[35%] text-[13px] text-gray-700 font-medium">Nama Produk</span>
                        <span class="w-4 text-[13px] text-gray-700 font-medium">:</span>
                        <span class="flex-1 text-[13px] text-gray-900 font-medium text-right">Selada Paket Reseler/Tengkulak (minim 10Kg)</span>
                    </div>
                    <div class="flex items-start">
                        <span class="w-[35%] text-[13px] text-gray-700 font-medium">Metode Pengiriman</span>
                        <span class="w-4 text-[13px] text-gray-700 font-medium">:</span>
                        <span class="flex-1 text-[13px] text-gray-900 font-medium text-right">Metode Pengiriman</span>
                    </div>
                    <div class="flex items-start">
                        <span class="w-[35%] text-[13px] text-gray-700 font-medium">Jumlah Produk</span>
                        <span class="w-4 text-[13px] text-gray-700 font-medium">:</span>
                        <span class="flex-1 text-[13px] text-gray-900 font-medium text-right">2</span>
                    </div>
                    <div class="flex items-start">
                        <span class="w-[35%] text-[13px] text-gray-700 font-medium">Harga Produk</span>
                        <span class="w-4 text-[13px] text-gray-700 font-medium">:</span>
                        <span class="flex-1 text-[13px] text-gray-900 font-medium text-right">Rp 200.000</span>
                    </div>
                </div>

                <!-- Total Harga (Ditambahkan Tombol Receipt) -->
                <div class="border-t border-b border-gray-200 py-5 my-2 flex items-center">
                    <span class="w-[35%] text-[14px] font-medium text-gray-700">Total Harga</span>
                    <span class="w-4 text-[14px] font-medium text-gray-700">:</span>
                    <div class="flex-1 flex justify-end items-center gap-3">
                        <span class="text-xl font-extrabold text-[#2F8540]">Rp 400.000</span>
                        
                        <!-- Tombol Receipt -->
                        <button type="button" class="bg-[#2B6A94] hover:bg-[#1E5276] text-white px-3 py-1.5 rounded-md text-[12px] font-semibold flex items-center gap-1.5 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Receipt
                        </button>
                    </div>
                </div>
                
                <!-- Status Pemesanan & Konfirmasi -->
                <div class="pt-4 flex items-center justify-between mt-auto" 
                     x-data="{ isConfirmed: false, openStatus: false, status: 'Diproses' }">
                    
                    <span class="text-[14px] font-medium text-gray-700">Status Pemesanan</span>
                    
                    <!-- FASE 1: BELUM DIKONFIRMASI -->
                    <div x-show="!isConfirmed" class="flex gap-2">
                        <!-- Tombol Konfirmasi -->
                        <button type="button" @click="isConfirmed = true" class="bg-[#2F8540] hover:bg-[#246631] text-white px-5 py-2.5 rounded-lg text-[13px] font-semibold transition shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Konfirmasi 
                        </button>
                    </div>

                    <!-- FASE 2: SUDAH DIKONFIRMASI (Dropdown Muncul) -->
                    <div x-show="isConfirmed" x-cloak class="relative inline-block text-left">
                        
                        <button type="button" @click="openStatus = !openStatus" 
                                @click.away="openStatus = false" 
                                :class="{
                                    'bg-[#F59E0B] hover:bg-[#D97706]': status === 'Diproses',
                                    'bg-[#3B82F6] hover:bg-[#2563EB]': status === 'Dikirim',
                                    'bg-[#2F8540] hover:bg-[#246631]': status === 'Selesai'
                                }"
                                class="text-white px-5 py-2.5 rounded-lg text-[13px] font-semibold flex items-center justify-between gap-3 transition shadow-sm min-w-[140px]">
                            
                            <span x-text="status">Diproses</span>
                            
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 7l5 5 5-5H5z"/>
                            </svg>
                        </button>

                        <div x-show="openStatus" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 top-full mt-2 w-40 bg-white rounded-lg shadow-[0_4px_20px_rgba(0,0,0,0.15)] border border-gray-200 py-2 z-50">
                             
                            <a href="#" @click.prevent="status = 'Diproses'; openStatus = false" class="block px-5 py-2.5 text-[15px] font-semibold text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">Diproses</a>
                            <a href="#" @click.prevent="status = 'Dikirim'; openStatus = false" class="block px-5 py-2.5 text-[15px] font-semibold text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">Dikirim</a>
                            <a href="#" @click.prevent="status = 'Selesai'; openStatus = false" class="block px-5 py-2.5 text-[15px] font-semibold text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">Selesai</a>     
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>