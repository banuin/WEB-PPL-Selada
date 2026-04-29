<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Artikel - SELADAKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#F8FAF5] min-h-screen font-sans relative">

    {{-- Tombol Back --}}
    <div class="px-10 pt-8 absolute top-0 left-0 z-10">
        <a href="{{ route('admin.artikel.index') }}" class="text-gray-800 hover:text-black transition">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
    </div>

    {{-- Form Container --}}
    <div class="w-full min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-4xl bg-white rounded-3xl shadow-md p-10 md:p-14 border border-gray-100">
            
            <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data" x-data="{ fileName: '' }">
                @csrf
                
                {{-- Judul Artikel --}}
                <div class="mb-8">
                    <label class="block text-[15px] font-extrabold text-black mb-3">Judul artikel</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full h-14 rounded-2xl px-5 border {{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }} focus:outline-none focus:border-green-600 transition-colors">
                    @error('title') 
                        <span class="text-red-500 text-xs mt-2 block font-semibold">{{ $message }}</span> 
                    @enderror
                </div>

                {{-- Deskripsi (Isi artikel) --}}
                <div class="mb-8">
                    <label class="block text-[15px] font-extrabold text-black mb-3">Deskripsi(Isi artikel)</label>
                    <textarea name="content" rows="6"
                        class="w-full rounded-2xl p-5 border {{ $errors->has('content') ? 'border-red-500' : 'border-gray-300' }} focus:outline-none focus:border-green-600 transition-colors resize-none">{{ old('content') }}</textarea>
                    @error('content') 
                        <span class="text-red-500 text-xs mt-2 block font-semibold">{{ $message }}</span> 
                    @enderror
                </div>

                {{-- Baris Bawah: Upload Gambar & Tombol Submit --}}
                <div class="flex justify-between items-start mt-4">
                    
                    {{-- Input Gambar Custom --}}
                    <div>
                        <input type="file" name="image" id="gambar" class="hidden" accept="image/*" @change="fileName = $refs.gambarInput.files[0].name" x-ref="gambarInput">
                        
                        <label for="gambar" class="flex items-center gap-2 border border-gray-300 px-5 py-3 rounded-xl cursor-pointer hover:bg-gray-50 transition text-sm font-semibold text-gray-700">
                            <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span x-text="fileName === '' ? 'Tambah gambar' : fileName">Tambah gambar</span>
                        </label>
                        @error('image') 
                            <span class="text-red-500 text-xs mt-2 block font-semibold">{{ $message }}</span> 
                        @enderror
                    </div>

                    {{-- Tombol Submit --}}
                    <button type="submit" class="flex items-center gap-2 bg-[#2F8540] hover:bg-[#266d33] text-white px-6 py-3.5 rounded-xl font-bold transition shadow-sm text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Unggah artikel
                    </button>
                    
                </div>
            </form>

        </div>
    </div>
</body>
</html>