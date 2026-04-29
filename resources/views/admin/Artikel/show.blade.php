<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Artikel - SELADAKU</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-[#FAFAFA] antialiased text-gray-800">

    <div class="max-w-4xl mx-auto px-4 py-12">
        
        <div class="flex items-center justify-between mb-6 px-2">
            <a href="{{ auth()->user()->role == 'admin' ? route('admin.artikel.index') : route('pelanggan.home') }}" 
               class="p-2 text-gray-600 hover:bg-gray-200 rounded-full transition">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>

            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.artikel.edit', $artikel->id) }}" 
                   class="bg-[#2F8540] hover:bg-[#266d33] text-white px-6 py-2.5 rounded-xl font-medium transition shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    Edit Artikel
                </a>
            @endif
        </div>

        <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden p-8 md:p-12">
            
            <h1 class="text-center text-2xl md:text-3xl font-medium text-gray-900 leading-tight mb-10">
                {{ $artikel->judul }}
            </h1>

            <div class="w-full h-64 md:h-[450px] rounded-[10px] overflow-hidden mb-10 shadow-sm">
                <img src="{{ asset('images/articles/' . $artikel->gambar) }}" 
                     class="w-full h-full object-cover" 
                     alt="{{ $artikel->judul }}">
            </div>
            <div class="border border-black/20 rounded-[10px] p-6 md:p-8">
                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed text-justify text-lg whitespace-pre-line">
                        {{ $artikel->deskripsi }}
                    </p>
                </div>

                <div class="text-right mt-6">
                    <p class="text-gray-400 text-xs md:text-sm font-medium italic">
                        Diterbitkan pada: {{ $artikel->created_at->format('d M Y') }}
                    </p>
                </div>
                <div x-data="{ openDelete: false }">
                <div class="flex justify-end mt-4">
                    <button type="button" @click="openDelete = true" class="bg-[#CC1A1A] hover:bg-red-800 text-white px-8 py-2 rounded-xl font-bold flex items-center gap-2 shadow-md transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus
                    </button>
                </div>

                <div x-show="openDelete" 
                    x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                    
                    <div @click.away="openDelete = false" 
                        class="bg-white w-full max-w-lg rounded-[30px] p-10 shadow-2xl border-2 border-[#3B82F6] transform transition-all text-center">
                        
                        <p class="text-xl font-bold text-black mb-10">
                            Apakah anda yakin ingin menghapus artikel ini?
                        </p>

                        <div class="flex justify-center gap-10">
                            <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-[#4CAF50] text-white px-12 py-3 rounded-2xl font-bold text-lg shadow-lg hover:bg-green-700 transition">
                                    YAKIN
                                </button>
                            </form>
                            <button type="button" @click="openDelete = false" class="bg-[#CC1A1A] text-white px-12 py-3 rounded-2xl font-bold text-lg shadow-lg hover:bg-red-800 transition">
                                BATAL
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>
</html>