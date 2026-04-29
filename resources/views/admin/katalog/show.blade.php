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

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10">
        
        <div class="flex flex-col gap-4">
            <img src="{{ asset('storage/' . $katalog->foto) }}" alt="{{ $katalog->judul }}" class="w-full aspect-square object-cover rounded-xl shadow-sm border border-gray-100">
            
            <div class="grid grid-cols-3 gap-4">
                <img src="{{ asset('storage/' . $katalog->foto) }}" class="aspect-square object-cover rounded-xl opacity-70 border border-gray-100">
                <div class="aspect-square bg-[#C4C4C4] rounded-xl opacity-30"></div>
                <div class="aspect-square bg-[#C4C4C4] rounded-xl opacity-30"></div>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h1 class="text-2xl font-extrabold text-black leading-snug">{{ $katalog->judul }}</h1>
            </div>

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

                <div class="mt-auto flex justify-end">
                    <a href="#" class="bg-[#2F8540] hover:bg-[#246631] text-white font-bold py-3 px-10 rounded-lg transition shadow-sm">
                        Edit Katalog
                    </a>
                </div>

            </div>
        </div>
    </div>

    @if(session('success'))
        <div id="success-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 flex items-center justify-center transition-opacity duration-300">
            <div class="bg-[#4CAF50] text-white px-10 py-5 rounded-2xl shadow-2xl font-bold text-lg transform scale-100 transition-transform">
                {{ session('success') }}
            </div>
        </div>

        <script>
            setTimeout(function() {
                const popup = document.getElementById('success-overlay');
                if(popup) {
                    popup.style.opacity = '0';
                    setTimeout(() => popup.style.display = 'none', 300); // Menunggu animasi opacity selesai
                }
            }, 2000);
        </script>
    @endif
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