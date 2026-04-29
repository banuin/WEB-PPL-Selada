<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Artikel - SELADAKU</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-[#FAFAFA] antialiased text-gray-800">

    <div class="max-w-4xl mx-auto px-4 py-12">
        
        <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="flex items-center justify-between mb-6 px-2">
                <a href="{{ route('artikel.show', $artikel->id) }}" 
                   class="p-2 text-gray-600 hover:bg-gray-200 rounded-full transition">
                    <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>

                <button type="submit" 
                   class="bg-[#2F8540] hover:bg-[#266d33] text-white px-6 py-2.5 rounded-xl font-medium transition shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>

            <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden p-8 md:p-12">
                
                <div class="text-center mb-10">
                    <input type="text" name="judul" 
                           class="w-full text-center text-2xl md:text-3xl font-medium text-gray-900 border-none focus:ring-0 bg-transparent placeholder-gray-300"
                           value="{{ old('judul', $artikel->judul) }}" placeholder="Masukkan Judul Artikel">
                    @error('judul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative w-full h-64 md:h-[450px] rounded-[10px] overflow-hidden mb-10 shadow-sm group">
                    <img src="{{ asset('images/articles/' . $artikel->gambar) }}" 
                         class="w-full h-full object-cover" id="previewImg">
                    
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                        <label class="cursor-pointer bg-white text-black px-4 py-2 rounded-lg font-bold text-sm">
                            Ganti Gambar
                            <input type="file" name="gambar" class="hidden" onchange="previewFile(this)">
                        </label>
                    </div>
                </div>

                <div class="border @error('deskripsi') border-red-500 @else border-black/20 @enderror rounded-[10px] p-6 md:p-8">
                    <div class="prose max-w-none">
                        <textarea name="deskripsi" 
                                  class="w-full min-h-[300px] text-gray-700 leading-relaxed text-justify text-lg bg-transparent border-none focus:ring-0 outline-none resize-none"
                                  placeholder="Tulis isi artikel di sini...">{{ old('deskripsi', $artikel->deskripsi) }}</textarea>
                    </div>

                    {{-- ALERT MERAH --}}
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-2 font-medium italic">harap lengkapi data artikel</p>
                    @enderror

                    <div class="text-right mt-6">
                        <p class="text-gray-400 text-xs md:text-sm font-medium italic">
                            Terakhir diubah: {{ now()->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewFile(input){
            var file = input.files[0];
            if(file){
                var reader = new FileReader();
                reader.onload = function(){
                    document.getElementById("previewImg").src = reader.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>