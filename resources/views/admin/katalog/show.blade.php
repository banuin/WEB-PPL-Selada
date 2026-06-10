@extends('layouts.app')

@section('content')
<div class="p-8 md:p-12 relative">

    <a href="{{ route('admin.katalog.index') }}" class="inline-flex items-center text-gray-600 hover:text-black mb-8 transition">
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10">
        
        <div class="flex flex-col gap-4">
            
            <div class="w-full aspect-square rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                <img id="mainImage" 
                    src="{{ asset('storage/' . $katalog->foto[0]) }}" 
                    alt="{{ $katalog->judul }}" 
                    class="w-full h-full object-cover">
            </div>

            <div class="grid grid-cols-3 gap-4">
                @foreach($katalog->foto as $gambar)
                    <img src="{{ asset('storage/' . $gambar) }}" 
                        class="aspect-square w-full object-cover rounded-xl border border-gray-100 hover:opacity-100 transition opacity-60 cursor-pointer"
                        onclick="document.getElementById('mainImage').src='{{ asset('storage/' . $gambar) }}'">
                @endforeach
                
                {{-- Kotak kosong jika foto yang diunggah kurang dari 3 --}}
                @for($i = count($katalog->foto); $i < 3; $i++)
                    <div class="aspect-square bg-gray-200 rounded-xl opacity-50"></div>
                @endfor
            </div>

        </div> <div class="flex flex-col gap-4">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h1 class="text-2xl font-extrabold text-black leading-snug">{{ $katalog->judul }}</h1>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col flex-grow">
                
                <div class="mb-8">
                    <p class="text-sm font-medium text-black leading-relaxed">
                        {{ $katalog->deskripsi }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-8 mt-auto">
                    <div>
                        <label class="block text-sm font-bold text-black mb-2">Total Stok (KG):</label>
                        <div class="w-full px-4 py-3 border border-gray-400 rounded-lg text-sm text-center font-bold text-black">
                            {{ $katalog->stok }} KG
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-black mb-2">Harga (per 1 KG):</label>
                        <div class="w-full px-4 py-3 border border-gray-400 rounded-lg text-sm text-center font-bold text-[#2F8540]">
                            Rp.{{ number_format($katalog->harga, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <div x-data="{ showDeleteModal: false }">
                    
                    <div class="grid grid-cols-2 gap-4">
                        <form x-ref="formDelete" action="{{ route('admin.katalog.destroy', $katalog->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" @click="showDeleteModal = true" class="w-full bg-[#CC1A1A] text-white py-3 rounded-xl font-bold flex items-center justify-center gap-2 shadow-md hover:bg-red-800 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>
                        </form>

                        <a href="{{ route('admin.katalog.edit', $katalog->id) }}" class="w-full bg-[#2F8540] text-white py-3 rounded-xl font-bold flex items-center justify-center gap-2 shadow-md hover:bg-[#266d33] transition text-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Ubah katalog
                        </a>
                    </div>

                    <div x-show="showDeleteModal" 
                        style="display: none;"
                        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        
                        <div class="bg-white rounded-[20px] shadow-2xl p-10 max-w-lg w-full mx-4 border border-gray-100 transform transition-all"
                            @click.away="showDeleteModal = false"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90">
                            
                            <h3 class="text-center text-[18px] font-extrabold text-black mb-10 leading-relaxed">
                                Apakah anda yakin ingin menghapus produk katalog ini?
                            </h3>
                            
                            <div class="flex justify-center gap-6">
                                <button @click="$refs.formDelete.submit()" class="bg-[#4CAF50] text-white font-bold py-2.5 px-10 rounded-xl shadow-[0_4px_10px_rgba(76,175,80,0.3)] hover:bg-[#388E3C] transition transform hover:-translate-y-0.5">
                                    YAKIN
                                </button>
                                
                                <button @click="showDeleteModal = false" class="bg-[#D32F2F] text-white font-bold py-2.5 px-10 rounded-xl shadow-[0_4px_10px_rgba(211,47,47,0.3)] hover:bg-[#B71C1C] transition transform hover:-translate-y-0.5">
                                    BATAL
                                </button>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>
            
        </div> </div>

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

</div>
@endsection