<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Artikel - SELADAKU</title>
    <style>[x-cloak] { display: none !important; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-white min-h-screen font-sans">
    @if(session()->has('success'))
        <div x-data="{ showPopup: true }" 
             x-show="showPopup" x-cloak
             x-init="setTimeout(() => showPopup = false, 3000)"
             class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-500/20 backdrop-blur-sm transition-opacity">
            <div x-show="showPopup" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-[#6db56f] text-white px-16 py-5 rounded-[20px] shadow-xl w-auto max-w-2xl text-center">
                <p class="text-xl font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Header Section (Tombol Back, Judul, Tombol Buat) --}}
    <div class="w-full px-10 py-8 flex justify-between items-center border-b border-gray-100 mb-8">
        
        <div class="flex items-center gap-6">
            {{-- Tombol Back ke Dashboard --}}
            <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('pelanggan.home') }}" 
                class="text-gray-800 hover:text-black transition">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>                                      
            </a>
            
            {{-- Judul Halaman --}}
            <h1 class="text-2xl font-extrabold text-black">Artikel</h1>
        </div>

        {{-- Tombol Buat Artikel --}}
        <a href="{{ route('admin.artikel.create') }}" class="flex items-center gap-2 bg-[#2F8540] hover:bg-[#266d33] text-white px-5 py-2.5 rounded-lg font-semibold transition shadow-sm text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat artikel
        </a>

    </div>

    {{-- Grid Kartu Artikel --}}
    <div class="px-10 pb-16 w-full max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-10">
            
            {{-- Menampilkan Artikel dari Database --}}
            @forelse($artikels  as $item)
            <div class="bg-white rounded-[20px] shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden flex flex-col p-4">
                
                {{-- Gambar Thumbnail --}}
                <div class="w-full h-48 rounded-xl overflow-hidden mb-5 bg-gray-100">
                    {{-- Memanggil gambar dari folder public/images/articles --}}
                    @if($item->gambar)
                        <img src="{{ asset('images/articles/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                    @endif
                </div>

                {{-- Judul Artikel --}}
                <h2 class="text-[16px] font-bold text-center text-black leading-tight mb-6 px-2">
                    {{ $item->judul }}
                </h2>

                <div class="flex-grow"></div>

                {{-- Tombol Selengkapnya --}}
                <a href="{{ route('artikel.show', $item->id) }}" 
                class="w-full bg-[#2F8540] hover:bg-[#266d33] text-white font-semibold text-sm py-3 rounded-xl text-center transition shadow-sm block">
                    Selengkapnya
                </a>

            </div>
            @empty
            {{-- Muncul ini jika database kosong --}}
            <div class="col-span-full flex flex-col items-center justify-center py-20 opacity-60">
                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 4v5h5M12 11v6m-3-3h6"></path></svg>
                <p class="text-gray-600 text-lg font-semibold">Belum ada artikel yang dibuat.</p>
            </div>
            @endforelse

        </div>
    </div>

</body>
</html>