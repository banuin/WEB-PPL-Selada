<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pelanggan - SELADAKU</title>
    <style>[x-cloak] { display: none !important; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#F3F4F6] min-h-screen flex flex-col items-center p-6 font-sans">

    {{-- Tombol Back --}}
    <div class="w-full max-w-5xl mb-4">
        <a href="{{ route('admin.pelanggan.index') }}" class="text-gray-800 hover:text-black transition inline-block">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
    </div>

    {{-- Kotak Utama (Menggunakan x-data untuk pop-up hapus) --}}
    <div x-data="{ showDeleteConfirm: false }" class="w-full max-w-5xl bg-white rounded-[30px] shadow-sm p-10 md:p-16 relative">
        
        <div x-show="showDeleteConfirm" x-cloak 
             class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/40 backdrop-blur-sm">
            <div @click.away="showDeleteConfirm = false" 
                 x-show="showDeleteConfirm"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-white rounded-2xl shadow-xl w-[500px] p-10 text-center border border-gray-200">
                
                <p class="font-bold text-black text-lg mb-10 mt-2">Apakah anda yakin ingin menghapus akun pengguna ini?</p>
                
                <div class="flex justify-center gap-6">
                    <form action="{{ route('admin.pelanggan.destroy', $pelanggan->id) }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" 
                                class="bg-[#4CAF50] hover:bg-[#45a049] text-white font-bold py-2.5 px-12 rounded-lg shadow-sm transition-colors tracking-wide">
                            YAKIN
                        </button>
                    </form>

                    <button type="button" @click="showDeleteConfirm = false" 
                            class="bg-[#D32F2F] hover:bg-[#c62828] text-white font-bold py-2.5 px-12 rounded-lg shadow-sm transition-colors tracking-wide">
                        BATAL
                    </button>
                </div>
            </div>
        </div>

        {{-- Header Profil --}}
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-[28px] font-extrabold text-black">Profil {{ '@' . $pelanggan->username }}</h1>
            
            <button @click="showDeleteConfirm = true" 
                class="flex items-center gap-2 bg-[#D32F2F] hover:bg-[#c62828] text-white px-5 py-2.5 rounded-lg font-bold transition shadow-sm text-sm opacity-80 hover:opacity-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Hapus Akun
            </button>
        </div>

        {{-- Grid Data Pelanggan (Read Only / Latar Abu-abu) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-8">
            
            <div class="flex flex-col">
                <label class="block text-sm font-bold text-black mb-2">Username</label>
                <input type="text" readonly value="{{ $pelanggan->username }}"
                    class="w-full h-12 rounded-[20px] px-5 font-semibold bg-[#E5E7EB] border-transparent text-gray-800 cursor-default focus:outline-none">
            </div>

            <div class="flex flex-col">
                <label class="block text-sm font-bold text-black mb-2">Email</label>
                <input type="email" readonly value="{{ $pelanggan->email }}"
                    class="w-full h-12 rounded-[20px] px-5 font-semibold bg-[#E5E7EB] border-transparent text-gray-800 cursor-default focus:outline-none">
            </div>

            <div class="flex flex-col">
                <label class="block text-sm font-bold text-black mb-2">Password</label>
                <input type="password" readonly value="********"
                    class="w-full h-12 rounded-[20px] px-5 font-bold tracking-widest bg-[#E5E7EB] border-transparent text-gray-800 cursor-default focus:outline-none">
            </div>

            <div class="flex flex-col">
                <label class="block text-sm font-bold text-black mb-2">Nomor Telepon</label>
                <input type="text" readonly value="{{ $pelanggan->nomor_telpon }}"
                    class="w-full h-12 rounded-[20px] px-5 font-semibold bg-[#E5E7EB] border-transparent text-gray-800 cursor-default focus:outline-none">
            </div>

            <div class="flex flex-col">
                <label class="block text-sm font-bold text-black mb-2">Nama Lengkap</label>
                <input type="text" readonly value="{{ $pelanggan->name }}"
                    class="w-full h-12 rounded-[20px] px-5 font-semibold bg-[#E5E7EB] border-transparent text-gray-800 cursor-default focus:outline-none">
            </div>

            <div class="flex flex-col">
                <label class="block text-sm font-bold text-black mb-2">Alamat</label>
                <input type="text" readonly value="{{ $pelanggan->alamat }}"
                    class="w-full h-12 rounded-[20px] px-5 font-semibold bg-[#E5E7EB] border-transparent text-gray-800 cursor-default focus:outline-none">
            </div>

        </div>
    </div>
</body>
</html>