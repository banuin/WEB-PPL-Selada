<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Katalog - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAFAFA] font-sans antialiased text-gray-800 p-8 md:p-12 relative">

    <a href="{{ route('admin.katalog.index') }}" class="inline-flex items-center text-gray-600 hover:text-black mb-8 transition">
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>

    <!-- Container Utama: Dibagi 2 Kolom -->
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10">
        
        <!-- ================= KOLOM KIRI (FOTO) ================= -->
        <div class="flex flex-col gap-4">
            
            <!-- Foto Utama -->
            <div class="w-full aspect-square rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                <img id="mainImage" 
                    src="{{ asset('storage/' . $katalog->foto[0]) }}" 
                    alt="{{ $katalog->judul }}" 
                    class="w-full h-full object-cover">
            </div>

            <!-- Thumbnail -->
            <div class="grid grid-cols-3 gap-4">
                @foreach($katalog->foto as $gambar)
                    <img src="{{ asset('storage/' . $gambar) }}" 
                        class="aspect-square w-full object-cover rounded-xl border border-gray-100 hover:opacity-100 transition opacity-60 cursor-pointer"
                        onclick="document.getElementById('mainImage').src='{{ asset('storage/' . $gambar) }}'">
                @endforeach
                
                {{-- Kotak kosong jika foto yang diunggah kurang dari 3 --}}
                @for($i = count($katalog->foto); $i < 3; $i++)
                    <div class="aspect-square bg-gray-200 rounded-xl opacity-50"></div>
                @endfor
            </div>

        </div> <!-- Akhir Kolom Kiri -->

        <!-- ================= KOLOM KANAN (DETAIL & TOMBOL) ================= -->
        <div class="flex flex-col gap-4">
            
            <!-- Judul -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h1 class="text-2xl font-extrabold text-black leading-snug">{{ $katalog->judul }}</h1>
            </div>

            <!-- Isi Detail -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col flex-grow">
                
                <div class="mb-8">
                    <p class="text-sm font-medium text-black leading-relaxed">
                        {{ $katalog->deskripsi }}
                    </p>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-bold text-black mb-3">Berat:</label>
                    <div class="flex gap-3">
                        @foreach([10, 20, 30, 40, 50] as $b)
                            <span class="px-5 py-2 rounded-full text-xs font-bold text-white {{ $katalog->berat == $b ? 'bg-[#0E3E20]' : 'bg-gray-500' }}">
                                {{ $b }}KG
                            </span>
                        @endforeach
                    </div>  
                </div>
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-bold text-black mb-2">Stock:</label>
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

                <!-- Wrapper Alpine.js untuk Modal Hapus -->
            <div x-data="{ showDeleteModal: false }" class="mt-8">
                
                <!-- Tombol Aksi Bawah -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Form Hapus (Ditambahkan x-ref agar bisa di-submit dari modal) -->
                    <form x-ref="formDelete" action="{{ route('admin.katalog.destroy', $katalog->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <!-- Perhatikan: type diubah jadi "button" dan ditambah @click -->
                        <button type="button" @click="showDeleteModal = true" class="w-full bg-[#CC1A1A] text-white py-3 rounded-xl font-bold flex items-center justify-center gap-2 shadow-md hover:bg-red-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus
                        </button>
                    </form>

                    <a href="{{ route('admin.katalog.edit', $katalog->id) }}" class="w-full bg-[#2F8540] text-white py-3 rounded-xl font-bold flex items-center justify-center gap-2 shadow-md hover:bg-[#266d33] transition text-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Ubah katalog
                    </a>
                </div>

                <!-- ================= MODAL KONFIRMASI HAPUS ================= -->
                <div x-show="showDeleteModal" 
                    style="display: none;"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    
                    <!-- Kotak Modal -->
                    <div class="bg-white rounded-[20px] shadow-2xl p-10 max-w-lg w-full mx-4 border border-gray-100 transform transition-all"
                        @click.away="showDeleteModal = false"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-90">
                        
                        <h3 class="text-center text-[18px] font-extrabold text-black mb-10 leading-relaxed">
                            Apakah anda yakin ingin menghapus produk katalog ini?
                        </h3>
                        
                        <div class="flex justify-center gap-6">
                            <!-- Tombol YAKIN: Mengirim Form -->
                            <button @click="$refs.formDelete.submit()" class="bg-[#4CAF50] text-white font-bold py-2.5 px-10 rounded-xl shadow-[0_4px_10px_rgba(76,175,80,0.3)] hover:bg-[#388E3C] transition transform hover:-translate-y-0.5">
                                YAKIN
                            </button>
                            
                            <!-- Tombol BATAL: Menutup Modal -->
                            <button @click="showDeleteModal = false" class="bg-[#D32F2F] text-white font-bold py-2.5 px-10 rounded-xl shadow-[0_4px_10px_rgba(211,47,47,0.3)] hover:bg-[#B71C1C] transition transform hover:-translate-y-0.5">
                                BATAL
                            </button>
                        </div>
                        
                    </div>
                </div>

            </div>
                
            </div>
        </div> <!-- Akhir Kolom Kanan -->

    </div>

    <!-- Popup Sukses (Cukup 1 saja pakai Alpine.js) -->
    @if(session('success'))
    <div x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 3000)" 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
        
        <div class="bg-[#58B463] text-white px-12 py-5 rounded-2xl shadow-2xl border border-white/20">
            <p class="text-xl font-bold tracking-wide text-center">
                {{ session('success') }}
            </p>
        </div>
    </div>
    @endif

</body>
</html>