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

    <div x-data="{ showSaveModal: false }" class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10">
        
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
            
        </div>

        <form id="formUpdate" action="{{ route('admin.katalog.update', $katalog->id) }}" method="POST" class="flex flex-col gap-4">
            @csrf
            @method('PUT')

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <input type="text" name="judul" value="{{ old('judul', $katalog->judul) }}" placeholder="Nama Produk" class="w-full text-2xl font-extrabold text-black leading-snug border-none focus:ring-0 p-0 placeholder-gray-300">
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col flex-grow">
                
                <div class="mb-8">
                    <label class="block text-sm font-medium text-black mb-2">Deskripsi produk</label>
                    <textarea name="deskripsi" rows="5" placeholder="Deskripsi produk..." class="w-full text-sm font-medium text-black leading-relaxed border border-gray-200 rounded-lg p-3 focus:ring-[#2F8540] focus:border-[#2F8540] resize-none">{{ old('deskripsi', $katalog->deskripsi) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-8 mt-auto">
                    <div>
                        <label class="block text-sm font-bold text-black mb-2">Total Stok (KG):</label>
                        <input type="number" name="stok" value="{{ old('stok', $katalog->stok) }}" class="w-full px-4 py-3 border border-gray-400 rounded-lg text-sm text-center font-bold text-black focus:outline-none focus:ring-[#2F8540] focus:border-[#2F8540]">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-black mb-2">Harga (per 1 KG):</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-sm font-bold text-[#2F8540]">Rp.</span>
                            <input type="text" name="harga" value="{{ old('harga', $katalog->harga) }}" class="w-full pl-10 pr-4 py-3 border border-gray-400 rounded-lg text-sm font-bold text-[#2F8540] focus:outline-none focus:ring-[#2F8540] focus:border-[#2F8540]">
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex flex-col items-end">
                    @if($errors->any())
                        <div class="w-full mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                            <p class="text-red-700 font-bold mb-2 text-sm">Validasi Gagal Karena:</p>
                            <ul class="list-disc pl-5 text-red-600 text-xs font-medium space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @elseif(session('error_katalog'))
                        <p class="text-[#CC1A1A] text-sm font-bold mb-3">Harap lengkapi data katalog</p>
                    @endif
                    
                    <button type="button" @click="showSaveModal = true" class="bg-[#2F8540] hover:bg-[#246631] text-white px-10 py-3 rounded-lg font-bold shadow-md transition w-full md:w-auto">
                        Simpan
                    </button>
                </div>
                
            </div>
        </form>

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