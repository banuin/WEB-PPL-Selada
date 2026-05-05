<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog - Admin SELADAKU</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-[#FAFAFA] antialiased text-gray-800">

    <div class="max-w-7xl mx-auto px-6 py-10">

        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-black transition flex items-center p-2 -ml-2">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>

            <a href="{{ route('admin.katalog.create') }}" class="bg-[#2F8540] hover:bg-[#246631] text-white px-4 py-2.5 rounded-lg flex items-center gap-2 text-sm font-medium transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="4"></rect>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"></path>
                </svg>
                Tambah katalog
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            @forelse ($katalogs as $item)
            <a href="{{ route('admin.katalog.show', $item->id) }}" class="bg-white p-4 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 flex flex-col h-full hover:shadow-md transition group">
                
                <!-- Menampilkan foto pertama dari array -->
                <div class="w-full h-48 overflow-hidden rounded-xl mb-5">
                    <img src="{{ asset('storage/' . $item->foto[0]) }}" 
                         alt="{{ $item->judul }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>

                <h3 class="text-[15px] font-bold text-gray-800 leading-snug mb-2 pr-4">
                    {{ $item->judul }}<br>
                    <span class="text-xs text-gray-500 font-medium">(minim {{ $item->berat }}Kg)</span>
                </h3>

                <p class="text-[#2F8540] font-bold text-[15px] mt-auto">
                    Rp{{ number_format($item->harga, 0, ',', '.') }}
                </p>
            </a>
            @empty
            <div class="col-span-full py-20 text-center">
                <p class="text-gray-400 italic">Belum ada katalog yang ditambahkan.</p>
            </div>
            @endforelse

        </div>

    </div>
    @if(session('success'))
    <div x-data="{ show: true }" 
         x-init="setTimeout(() => show = false, 2500)" 
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[200] flex items-center justify-center bg-black/40 backdrop-blur-sm">
        
        <!-- Kotak Hijau -->
        <div x-show="show"
             x-transition:enter="transition ease-out duration-300 delay-100"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="bg-[#4CAF50] px-16 py-5 rounded-2xl shadow-xl border border-green-600/30">
             
            <p class="text-white text-[18px] font-bold tracking-wide text-center">
                {{ session('success') }}
            </p>
            
        </div>
    </div>
    @endif

</body>
</html>