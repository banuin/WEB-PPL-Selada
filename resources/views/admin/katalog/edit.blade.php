<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Katalog - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAFAFA] font-sans antialiased text-gray-800 p-8 md:p-12 relative">

    <a href="{{ route('admin.katalog.show', $katalog->id) }}" class="inline-flex items-center text-gray-600 hover:text-black mb-8 transition">
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>

    <!-- x-data untuk kontrol modal simpan dan pilihan berat -->
    <div x-data="{ showSaveModal: false, selectedBerat: {{ old('berat', $katalog->berat) }} }" class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10">
        
        <!-- ================= KOLOM KIRI (FOTO) ================= -->
        <div class="flex flex-col gap-4">
            <div class="w-full aspect-square rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                <img id="mainImage" 
                    src="{{ asset('storage/' . $katalog->foto[0]) }}" 
                    class="w-full h-full object-cover">
            </div>

            <div class="grid grid-cols-3 gap-4">
                @foreach($katalog->foto as $gambar)
                    <img src="{{ asset('storage/' . $gambar) }}" 
                        class="aspect-square w-full object-cover rounded-xl border border-gray-100 hover:opacity-100 transition opacity-60 cursor-pointer"
                        onclick="document.getElementById('mainImage').src='{{ asset('storage/' . $gambar) }}'">
                @endforeach
                @for($i = count($katalog->foto); $i < 3; $i++)
                    <div class="aspect-square bg-gray-200 rounded-xl opacity-50"></div>
                @endfor
            </div>
            
            {{-- Opsional: Input file jika ingin ganti gambar --}}
            {{-- <input type="file" name="foto[]" multiple form="formUpdate"> --}}
        </div>

        <!-- ================= KOLOM KANAN (FORM UBAH) ================= -->
        <form id="formUpdate" action="{{ route('admin.katalog.update', $katalog->id) }}" method="POST" class="flex flex-col gap-4">
            @csrf
            @method('PUT')

            <!-- Judul -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <input type="text" name="judul" value="{{ old('judul', $katalog->judul) }}" placeholder="Nama Produk" class="w-full text-2xl font-extrabold text-black leading-snug border-none focus:ring-0 p-0 placeholder-gray-300">
            </div>

            <!-- Isi Detail -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col flex-grow">
                
                <div class="mb-8">
                    <textarea name="deskripsi" rows="5" placeholder="Deskripsi produk..." class="w-full text-sm font-medium text-black leading-relaxed border border-gray-200 rounded-lg p-3 focus:ring-[#2F8540] focus:border-[#2F8540] resize-none">{{ old('deskripsi', $katalog->deskripsi) }}</textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-bold text-black mb-3">Berat:</label>
                    <!-- Input Hidden untuk Berat -->
                    <input type="hidden" name="berat" :value="selectedBerat">
                    
                    <div class="flex gap-3">
                        @foreach([10, 20, 30, 40, 50] as $b)
                            <button type="button" @click="selectedBerat = {{ $b }}" 
                                :class="selectedBerat == {{ $b }} ? 'bg-[#0E3E20]' : 'bg-gray-500'"
                                class="px-5 py-2 rounded-full text-xs font-bold text-white transition">
                                {{ $b }}KG
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-bold text-black mb-2">Stock:</label>
                        <input type="number" name="stok" value="{{ old('stok', $katalog->stok) }}" class="w-full px-4 py-3 border border-gray-400 rounded-lg text-sm text-center font-bold text-black focus:ring-[#2F8540] focus:border-[#2F8540]">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-black mb-2">Harga:</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-sm font-bold text-[#2F8540]">Rp.</span>
                            <input type="text" name="harga" value="{{ old('harga', $katalog->harga) }}" class="w-full pl-10 pr-4 py-3 border border-gray-400 rounded-lg text-sm font-bold text-[#2F8540] focus:ring-[#2F8540] focus:border-[#2F8540]">
                        </div>
                    </div>
                </div>

                <!-- Pesan Error Validasi & Tombol Simpan -->
                <div class="mt-auto text-right">
                    @if(session('error_katalog') || $errors->any())
                        <p class="text-[#CC1A1A] text-sm font-bold mb-3">Harap lengkapi data katalog</p>
                    @endif
                    
                    <button type="button" @click="showSaveModal = true" class="bg-[#2F8540] hover:bg-[#246631] text-white px-10 py-2.5 rounded-lg font-bold shadow-md transition">
                        Simpan
                    </button>
                </div>
                
            </div>
        </form>

        <!-- ================= MODAL KONFIRMASI SIMPAN ================= -->
        <div x-show="showSaveModal" 
             style="display: none;"
             class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
             
            <div class="bg-white rounded-[20px] shadow-2xl p-10 max-w-lg w-full mx-4 border border-gray-100 transform transition-all"
                 @click.away="showSaveModal = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90">
                
                <h3 class="text-center text-[18px] font-extrabold text-black mb-10 leading-relaxed">
                    Apakah anda yakin ingin menyimpan perubahan?
                </h3>
                
                <div class="flex justify-center gap-6">
                    <!-- Submit Form via Alpine -->
                    <button @click="document.getElementById('formUpdate').submit()" class="bg-[#4CAF50] text-white font-bold py-2.5 px-10 rounded-xl shadow-[0_4px_10px_rgba(76,175,80,0.3)] hover:bg-[#388E3C] transition transform hover:-translate-y-0.5">
                        YAKIN
                    </button>
                    <button @click="showSaveModal = false" class="bg-[#D32F2F] text-white font-bold py-2.5 px-10 rounded-xl shadow-[0_4px_10px_rgba(211,47,47,0.3)] hover:bg-[#B71C1C] transition transform hover:-translate-y-0.5">
                        BATAL
                    </button>
                </div>
            </div>
        </div>

    </div>

</body>
</html> 