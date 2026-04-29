<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Saya - SELADAKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F3F4F6] min-h-screen font-sans">

    {{-- Tombol Back di luar card --}}
    <div class="px-8 pt-6">
        <a href="javascript:history.back()" class="text-gray-800 hover:text-black transition inline-block">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
    </div>

    <div x-data="{ editMode: {{ $errors->any() ? 'true' : 'false' }} }" class="w-full min-h-screen flex items-center justify-center bg-[#F3F4F6] p-6 font-sans">
        <div class="w-full max-w-5xl bg-white rounded-[30px] shadow-sm p-10 md:p-16 relative border-t-8 border-[#2F8540]">
            <form action="{{ route('profil.update') }}" method="POST">
                @csrf
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h1 class="text-3xl font-extrabold text-black">Profil Saya</h1>
                        <p class="text-gray-500 text-sm">Kelola informasi akun Anda</p>
                    </div>
                    <button type="button" x-show="!editMode" @click="editMode = true" class="flex items-center gap-2 bg-[#2F8540] hover:bg-[#266d33] text-white px-6 py-3 rounded-xl font-semibold transition shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Ubah Profil
                    </button>
                    <button type="submit" x-show="editMode" x-cloak class="bg-[#2F8540] hover:bg-[#266d33] text-white px-6 py-3 rounded-xl font-bold transition shadow-md">
                        Simpan Perubahan
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-8">
                    <div>
                        <label class="block text-lg font-bold text-black mb-2">Username</label>
                        <input type="text" name="username" :readonly="!editMode" value="{{ old('username', $user->username) }}"
                            class="w-full h-14 rounded-[20px] px-6 font-semibold transition-all focus:outline-none border-gray-200 shadow-sm
                            {{ $errors->has('username') ? 'border-2 border-red-500 bg-white' : '' }}
                            @if(!$errors->has('username')) :class="editMode ? 'bg-white border-2 border-green-600' : 'bg-[#E5E7EB] border-transparent text-gray-800'" @endif">
                        @error('username') <span class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-lg font-bold text-black mb-2">Email</label>
                        <input type="email" name="email" :readonly="!editMode" value="{{ old('email', $user->email) }}"
                            class="w-full h-14 rounded-[20px] px-6 font-semibold transition-all focus:outline-none border-gray-200 shadow-sm
                            {{ $errors->has('email') ? 'border-2 border-red-500 bg-white' : '' }}
                            @if(!$errors->has('email')) :class="editMode ? 'bg-white border-2 border-green-600' : 'bg-[#E5E7EB] border-transparent text-gray-800'" @endif">
                        @error('email') <span class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-lg font-bold text-black mb-2">Alamat</label>
                        <input type="text" name="alamat" :readonly="!editMode" value="{{ old('alamat', $user->alamat) }}"
                            class="w-full h-14 rounded-[20px] px-6 font-semibold transition-all focus:outline-none border-gray-200 shadow-sm
                            {{ $errors->has('alamat') ? 'border-2 border-red-500 bg-white' : '' }}
                            @if(!$errors->has('alamat')) :class="editMode ? 'bg-white border-2 border-green-600' : 'bg-[#E5E7EB] border-transparent text-gray-800'" @endif">
                        @error('alamat') <span class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-lg font-bold text-black mb-2">Password</label>
                        <input type="password" name="password" :readonly="!editMode" placeholder="••••••••••••"
                            class="w-full h-14 rounded-[20px] px-6 font-semibold transition-all focus:outline-none border-gray-200 shadow-sm"
                            :class="editMode ? 'bg-white border-2 border-green-600' : 'bg-[#E5E7EB] border-transparent text-gray-800'">
                        <span x-show="editMode" class="text-gray-400 text-[10px] mt-1 italic block">*Kosongkan jika tidak ingin diubah</span>
                    </div>

                    <div>
                        <label class="block text-lg font-bold text-black mb-2">Nomor Telepon</label>
                        <input type="text" name="nomor_telpon" :readonly="!editMode" value="{{ old('nomor_telpon', $user->nomor_telpon) }}"
                            class="w-full h-14 rounded-[20px] px-6 font-semibold transition-all focus:outline-none border-gray-200 shadow-sm
                            {{ $errors->has('nomor_telpon') ? 'border-2 border-red-500 bg-white' : '' }}
                            @if(!$errors->has('nomor_telpon')) :class="editMode ? 'bg-white border-2 border-green-600' : 'bg-[#E5E7EB] border-transparent text-gray-800'" @endif">
                        @error('nomor_telpon') <span class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-lg font-bold text-black mb-2">Nama Lengkap</label>
                        <input type="text" name="name" :readonly="!editMode" value="{{ old('name', $user->name) }}"
                            class="w-full h-14 rounded-[20px] px-6 font-semibold transition-all focus:outline-none border-gray-200 shadow-sm
                            {{ $errors->has('name') ? 'border-2 border-red-500 bg-white' : '' }}
                            @if(!$errors->has('name')) :class="editMode ? 'bg-white border-2 border-green-600' : 'bg-[#E5E7EB] border-transparent text-gray-800'" @endif">
                        @error('name') <span class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>