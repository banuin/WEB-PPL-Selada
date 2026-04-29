<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Admin - SELADAKU</title>
    <style>[x-cloak] { display: none !important; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#F3F4F6] min-h-screen flex flex-col items-center p-6 font-sans">

    <div class="w-full max-w-5xl mb-4">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-800 hover:text-black transition">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
    </div>

    @if(session()->has('success'))
        <div x-data="{ showPopup: true }" 
             x-show="showPopup" x-cloak 
             x-init="setTimeout(() => showPopup = false, 3000)"
             class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-500/20 backdrop-blur-sm transition-opacity">
            <div x-show="showPopup" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-[#6db56f] text-white px-20 py-5 rounded-[20px] shadow-xl w-auto max-w-2xl text-center border-none">
                <p class="text-xl font-bold">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div x-data="{ 
            editMode: {{ $errors->any() ? 'true' : 'false' }},
            showConfirm: false
         }" 
         class="w-full max-w-5xl bg-white rounded-[30px] shadow-sm p-10 md:p-16 relative border-t-8 border-[#2F8540]">
        
        <form action="{{ route('profil.update') }}" method="POST">
            @csrf
            
            <div x-show="showConfirm" x-cloak 
                 class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/40 backdrop-blur-sm">
                <div @click.away="showConfirm = false" 
                     x-show="showConfirm"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="bg-white rounded-2xl shadow-xl w-[500px] p-10 text-center border border-gray-200">
                    
                    <p class="font-bold text-black text-[17px] mb-10 mt-4">Apakah anda ingin menyimpan perubahan?</p>
                    
                    <div class="flex justify-center gap-6 px-4">
                        <button type="submit" 
                                class="w-1/2 bg-[#4CAF50] hover:bg-[#45a049] text-white font-bold py-3 rounded-xl shadow-sm transition-colors tracking-wide">
                            YA
                        </button>
                        <button type="button" @click="showConfirm = false" 
                                class="w-1/2 bg-[#D32F2F] hover:bg-[#c62828] text-white font-bold py-3 rounded-xl shadow-sm transition-colors tracking-wide">
                            TIDAK
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-extrabold text-black">Profil</h1>
                    <p class="text-gray-500 text-sm">Kelola informasi akun utama Anda</p>
                </div>
                
                <button type="button" x-show="!editMode" @click="editMode = true" 
                    class="flex items-center gap-2 bg-[#2F8540] hover:bg-[#266d33] text-white px-6 py-3 rounded-xl font-semibold transition shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    Ubah Profil
                </button>

                <button type="button" x-show="editMode" x-cloak @click="showConfirm = true"
                    class="flex items-center gap-2 bg-[#2F8540] hover:bg-[#266d33] text-white px-6 py-3 rounded-xl font-bold transition shadow-md">
                    Simpan Perubahan
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-8">
                <div class="flex flex-col">
                    <label class="block text-lg font-bold text-black mb-2">Username</label>
                    <input type="text" name="username" :readonly="!editMode" value="{{ old('username', $user->username) }}"
                        class="w-full h-14 rounded-[20px] px-6 font-semibold transition-all focus:outline-none {{ $errors->has('username') ? 'border-2 border-red-500 bg-white' : '' }}"
                        @if(!$errors->has('username')) :class="editMode ? 'bg-white border-2 border-green-600' : 'bg-[#E5E7EB] border-transparent text-gray-800'" @endif>
                    @error('username') <span class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col">
                    <label class="block text-lg font-bold text-black mb-2">Email</label>
                    <input type="email" name="email" :readonly="!editMode" value="{{ old('email', $user->email) }}"
                        class="w-full h-14 rounded-[20px] px-6 font-semibold transition-all focus:outline-none {{ $errors->has('email') ? 'border-2 border-red-500 bg-white' : '' }}"
                        @if(!$errors->has('email')) :class="editMode ? 'bg-white border-2 border-green-600' : 'bg-[#E5E7EB] border-transparent text-gray-800'" @endif>
                    @error('email') <span class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col">
                    <label class="block text-lg font-bold text-black mb-2">Password</label>
                    <input type="password" name="password" :readonly="!editMode" placeholder="••••••••••••"
                        class="w-full h-14 rounded-[20px] px-6 font-semibold transition-all focus:outline-none"
                        :class="editMode ? 'bg-white border-2 border-green-600' : 'bg-[#E5E7EB] border-transparent text-gray-800'">
                    <span x-show="editMode" class="text-gray-400 text-[10px] mt-1 italic block">*Kosongkan jika tidak ingin diubah</span>
                </div>

                <div class="flex flex-col">
                    <label class="block text-lg font-bold text-black mb-2">Nomor Telepon</label>
                    <input type="text" name="nomor_telpon" :readonly="!editMode" value="{{ old('nomor_telpon', $user->nomor_telpon) }}"
                        class="w-full h-14 rounded-[20px] px-6 font-semibold transition-all focus:outline-none {{ $errors->has('nomor_telpon') ? 'border-2 border-red-500 bg-white' : '' }}"
                        @if(!$errors->has('nomor_telpon')) :class="editMode ? 'bg-white border-2 border-green-600' : 'bg-[#E5E7EB] border-transparent text-gray-800'" @endif>
                    @error('nomor_telpon') <span class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col">
                    <label class="block text-lg font-bold text-black mb-2">Nama Lengkap Pengelola</label>
                    <input type="text" name="name" :readonly="!editMode" value="{{ old('name', $user->name) }}"
                        class="w-full h-14 rounded-[20px] px-6 font-semibold transition-all focus:outline-none {{ $errors->has('name') ? 'border-2 border-red-500 bg-white' : '' }}"
                        @if(!$errors->has('name')) :class="editMode ? 'bg-white border-2 border-green-600' : 'bg-[#E5E7EB] border-transparent text-gray-800'" @endif>
                    @error('name') <span class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</span> @enderror
                </div>
            </div>
        </form>
    </div>
</body>
</html>