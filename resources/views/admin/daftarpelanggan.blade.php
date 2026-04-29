<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Pelanggan - SELADAKU</title>
    <style>[x-cloak] { display: none !important; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#F3F4F6] min-h-screen font-sans">

    @if(session()->has('success'))
        <div x-data="{ showPopup: true }" 
             x-show="showPopup" x-cloak
             x-init="setTimeout(() => showPopup = false, 3000)"
             class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-500/20 backdrop-blur-sm transition-opacity">
            <div x-show="showPopup" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-[#5CB85C] border border-[#4cae4c] text-white px-12 py-5 rounded-2xl shadow-xl w-auto max-w-2xl text-center">
                <p class="text-xl font-bold">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Tombol Back ke Dashboard Admin --}}
    <div class="px-8 pt-6">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-800 hover:text-black transition inline-block">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
    </div>

    {{-- Kotak Utama --}}
    <div class="w-full flex justify-center p-6">
        <div class="w-full max-w-5xl bg-white rounded-[30px] shadow-sm p-10 md:p-16">
            <h1 class="text-[28px] font-extrabold text-black mb-10">Profil Pelanggan</h1>

            {{-- Daftar Pelanggan --}}
            <div class="space-y-6">
                
                @forelse($pelanggan as $p)
                <a href="{{ route('admin.pelanggan.show', $p->id) }}" class="flex items-center gap-4 bg-[#E1EAD1] hover:bg-[#d3e0bf] rounded-[20px] px-6 py-5 shadow-sm transition-colors cursor-pointer">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-black font-semibold text-lg">{{ '@' . $p->username }}</span>
                </a>
                
                @empty
                <p class="text-gray-500 text-center italic">Belum ada data pelanggan yang terdaftar.</p>
                @endforelse

            </div>

        </div>
    </div>
</body>
</html>