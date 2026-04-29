<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Katalog</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAFAFA] font-sans antialiased text-gray-800 p-8 md:p-12 relative">

    <a href="{{ route('admin.katalog.index') }}" class="inline-flex items-center text-gray-600 hover:text-black mb-8 transition">
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>

    <div class="max-w-6xl mx-auto" 
         x-data="{ 
            previews: [], 
            filesData: new DataTransfer(),
            
            // Pertahankan pilihan berat jika ada error (Old Input)
            beratTerpilih: '{{ old('berat', '') }}',
            
            // Logika Format Harga Rupiah dengan perlindungan Old Input
            hargaTampil: '{{ old('harga') ? 'Rp. ' . number_format(old('harga'), 0, ',', '.') : '' }}',
            hargaAsli: '{{ old('harga', '') }}',
            
            formatRupiah(event) {
                let angka = event.target.value.replace(/[^0-9]/g, ''); 
                this.hargaAsli = angka; 
                if (angka) {
                    this.hargaTampil = 'Rp. ' + new Intl.NumberFormat('id-ID').format(angka);
                } else {
                    this.hargaTampil = '';
                }
            },
            
            // Logika Upload Multiple Gambar
            fileChosen(event) {
                const newFiles = event.target.files;
                if (newFiles.length > 0) {
                    for (let i = 0; i < newFiles.length; i++) {
                        this.previews.push(URL.createObjectURL(newFiles[i]));
                        this.filesData.items.add(newFiles[i]);
                    }
                    document.getElementById('foto').files = this.filesData.files;
                }
            },
            
            // Logika Hapus Gambar dari Pratinjau
            removeImage(index) {
                this.previews.splice(index, 1);
                const dt = new DataTransfer();
                const currentFiles = this.filesData.files;
                for (let i = 0; i < currentFiles.length; i++) {
                    if (i !== index) dt.items.add(currentFiles[i]);
                }
                this.filesData = dt;
                document.getElementById('foto').files = this.filesData.files;
            }
         }">
        
        <form action="{{ route('admin.katalog.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            @csrf

            <div class="flex flex-col gap-4">
                
                <div class="w-full aspect-square bg-[#C4C4C4] rounded-xl overflow-hidden relative flex items-center justify-center border border-gray-200">
                    <template x-if="previews.length > 0">
                        <img :src="previews[0]" class="w-full h-full object-cover">
                    </template>
                </div>
                
                <div class="grid grid-cols-3 gap-4">
                    <template x-for="(image, index) in previews" :key="index">
                        <div class="aspect-square bg-[#C4C4C4] rounded-xl overflow-hidden border border-gray-200 relative group">
                            <img :src="image" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition">
                            
                            <template x-if="index === 0">
                                <span class="absolute top-1 left-1 bg-[#184F2A] text-white text-[9px] font-bold px-2 py-0.5 rounded shadow-sm z-10">UTAMA</span>
                            </template>

                            <button type="button" @click.stop="removeImage(index)" class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition z-10 shadow hover:bg-red-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </template>
                    
                    <template x-if="previews.length < 3">
                        <div class="contents">
                            <template x-for="i in (3 - previews.length)">
                                <div class="aspect-square bg-[#C4C4C4] rounded-xl border border-gray-200"></div>
                            </template>
                        </div>
                    </template>
                </div>

                <div class="text-center mt-2">
                    <input type="file" name="foto[]" id="foto" class="hidden" @change="fileChosen" accept="image/*" multiple>
                    <label for="foto" class="inline-flex items-center gap-2 px-6 py-2 border border-gray-400 rounded-lg text-sm font-medium hover:bg-gray-50 transition bg-white cursor-pointer">
                        <svg class="w-5 h-5 text-[#2F8540]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah gambar
                    </label>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Judul" 
                           class="w-full text-2xl font-extrabold text-black focus:outline-none placeholder-black/80">
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col flex-grow">
                    
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-black mb-2">Deskripsi produk</label>
                        <textarea name="deskripsi" rows="6" class="w-full border-none focus:ring-0 focus:outline-none resize-none text-sm font-medium leading-relaxed placeholder-gray-400" placeholder="Tuliskan deskripsi produk di sini...">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-bold text-black mb-3">Berat:</label>
                        <div class="flex gap-3">
                            <input type="hidden" name="berat" :value="beratTerpilih">
                            
                            @foreach([10, 20, 30, 40, 50] as $b)
                                <button type="button" 
                                        @click="beratTerpilih = '{{ $b }}'"
                                        :class="beratTerpilih == '{{ $b }}' ? 'bg-[#0E3E20] text-white' : 'bg-gray-500 text-white hover:bg-gray-600'"
                                        class="px-5 py-2 rounded-full text-xs font-bold transition">
                                    {{ $b }}KG
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-bold text-black mb-2">Stock:</label>
                            <input type="number" name="stok" value="{{ old('stok') }}" placeholder="50" 
                                   class="w-full px-4 py-3 border border-gray-400 rounded-lg text-sm text-center font-bold focus:outline-none focus:border-[#2F8540]">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-black mb-2">Harga:</label>
                            <div class="relative">
                                <input type="hidden" name="harga" :value="hargaAsli">
                                <input type="text" x-model="hargaTampil" @input="formatRupiah" placeholder="Rp. 100.000" 
                                       class="w-full px-4 py-3 border border-gray-400 rounded-lg text-sm text-center font-bold text-[#2F8540] focus:outline-none focus:border-[#2F8540]">
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto flex flex-col items-end">
                        @if(session('error_katalog') || $errors->any())
                            <p class="text-red-600 text-sm font-bold mb-3 tracking-wide">
                                Harap lengkapi data katalog
                            </p>
                        @endif

                        <button type="submit" class="bg-[#2F8540] hover:bg-[#246631] text-white font-bold py-3 px-10 rounded-lg transition shadow-sm w-full md:w-auto">
                            Unggah
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>

</body>
</html>