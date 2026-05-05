<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Produk - SELADAKU</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAFAFA] font-sans antialiased text-gray-800 p-8 md:p-12 relative">

    <!-- Tombol Kembali ke Home Pelanggan -->
    <a href="{{ route('pelanggan.home') }}" class="inline-flex items-center text-gray-600 hover:text-black mb-8 transition">
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span class="font-semibold text-sm">Kembali</span>
    </a>

    <!-- Container Utama -->
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10">
        
        <!-- KOLOM KIRI (FOTO) -->
        <div class="flex flex-col gap-4">
            <div class="w-full aspect-square rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                <img id="mainImage" src="{{ asset('storage/' . $katalog->foto[0]) }}" alt="{{ $katalog->judul }}" class="w-full h-full object-cover">
            </div>

            <div class="grid grid-cols-3 gap-4">
                @foreach($katalog->foto as $gambar)
                    <img src="{{ asset('storage/' . $gambar) }}" class="aspect-square w-full object-cover rounded-xl border border-gray-100 hover:opacity-100 transition opacity-60 cursor-pointer" onclick="document.getElementById('mainImage').src='{{ asset('storage/' . $gambar) }}'">
                @endforeach
                
                @for($i = count($katalog->foto); $i < 3; $i++)
                    <div class="aspect-square bg-gray-200 rounded-xl opacity-50"></div>
                @endfor
            </div>
        </div>

        <!-- KOLOM KANAN (DETAIL) -->
        <div class="flex flex-col gap-4">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h1 class="text-2xl font-extrabold text-black leading-snug">{{ $katalog->judul }}</h1>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col flex-grow">
                
                <div class="mb-8">
                    <p class="text-sm font-medium text-black leading-relaxed">{{ $katalog->deskripsi }}</p>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-bold text-black mb-3">Berat Minim:</label>
                    <span class="px-5 py-2 rounded-full text-xs font-bold text-white bg-[#0E3E20] shadow-sm">
                        {{ $katalog->berat }}KG
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-bold text-black mb-2">Stock Tersedia:</label>
                        <div class="w-full px-4 py-3 border border-gray-400 rounded-lg text-sm text-center font-bold text-black">
                            {{ $katalog->stok }}KG
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-black mb-2">Harga:</label>
                        <div class="w-full px-4 py-3 border border-gray-400 rounded-lg text-sm text-center font-bold text-[#2F8540]">
                            Rp.{{ number_format($katalog->harga, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <!-- TOMBOL PESAN (MENGGANTIKAN HAPUS & EDIT) -->
                <div class="mt-8">
                    <!-- Ganti nomor HP di bawah dengan nomor aslimu -->
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20SELADAKU,%20saya%20tertarik%20untuk%20memesan%20produk%20*{{ urlencode($katalog->judul) }}*%20sebanyak%20..." 
                       target="_blank" 
                       class="w-full bg-[#2F8540] text-white py-3.5 rounded-xl font-extrabold flex items-center justify-center gap-2 shadow-[0_4px_14px_rgba(47,133,64,0.3)] hover:bg-[#246631] transition transform hover:-translate-y-0.5 text-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Pesan Sekarang (WhatsApp)
                    </a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>