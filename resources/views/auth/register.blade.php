<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - SELADAKU</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen bg-cover bg-center flex items-center justify-center p-6" style="background-image: url('{{ asset('images/kebun-selada.jpg') }}');">
    
    <div class="w-full max-w-4xl bg-black/40 backdrop-blur-md border border-white/30 rounded-2xl p-8 md:p-12 shadow-2xl">
        <h2 class="text-3xl font-extrabold text-white mb-8">Seladaku</h2>
        

        
        <form action="{{ route('register.proses') }}" method="POST">
            @csrf
            @if(session('success'))
                <div id="successToast"
                    class="mb-4 p-4 rounded-lg bg-green-500 text-white text-center font-semibold shadow-lg">
                    {{ session('success') }}
                </div>

                <script>
                    setTimeout(function() {
                        window.location.href = "{{ route('login') }}";
                    }, 500);
                </script>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-white mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}"
                        class="w-full px-4 py-2.5 bg-transparent border rounded-xl text-white
                        {{ $errors->has('username') ? 'border-red-500' : 'border-white' }}">

                    @error('username')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-white mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2.5 bg-transparent border rounded-xl text-white
                        {{ $errors->has('name') ? 'border-red-500' : 'border-white' }}">

                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-white mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2.5 bg-transparent border rounded-xl text-white
                        {{ $errors->has('email') ? 'border-red-500' : 'border-white' }}">

                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-white mb-2">No. Telepon</label>
                    <input type="text" name="nomor_telpon" value="{{ old('nomor_telpon') }}"
                        class="w-full px-4 py-2.5 bg-transparent border rounded-xl text-white
                        {{ $errors->has('nomor_telpon') ? 'border-red-500' : 'border-white' }}">

                    @error('nomor_telpon')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-white mb-2">Kecamatan (Kab. Jember)</label>
                    <select name="kecamatan"
                        class="w-full px-4 py-2.5 bg-transparent border rounded-xl text-white outline-none
                        {{ $errors->has('kecamatan') ? 'border-red-500 font-bold bg-[#E5E7EB]' : 'border-white' }} [&>option]:text-black cursor-pointer">
                        <option value="" class="text-gray-400">Pilih Kecamatan</option>
                        @php
                            $kecamatans = [
                                'Ajung', 'Ambulu', 'Arjasa', 'Balung', 'Bangsalsari', 'Gumukmas', 'Jelbuk', 'Jenggawah',
                                'Jombang', 'Kalisat', 'Kaliwates', 'Kencong', 'Ledokombo', 'Mayang', 'Mumbulsari', 'Pakusari',
                                'Panti', 'Patrang', 'Puger', 'Rambipuji', 'Semboro', 'Silo', 'Sukorambi', 'Sukowono',
                                'Sumberbaru', 'Sumberjambe', 'Sumbersari', 'Tanggul', 'Tempurejo', 'Umbulsari', 'Wuluhan'
                            ];
                        @endphp
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec }}" {{ old('kecamatan') == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                        @endforeach
                    </select>

                    @error('kecamatan')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-white mb-2">Detail Alamat</label>
                    <input type="text" name="detail_alamat" value="{{ old('detail_alamat') }}" placeholder="Contoh: Jl. Mawar No. 12 RT 01 RW 03"
                        class="w-full px-4 py-2.5 bg-transparent border rounded-xl text-white placeholder-gray-300/60
                        {{ $errors->has('detail_alamat') ? 'border-red-500' : 'border-white' }}">

                    @error('detail_alamat')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-white mb-2">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2.5 bg-transparent border rounded-xl text-white
                        {{ $errors->has('password') ? 'border-red-500' : 'border-white' }}">

                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
            </div>
            <button type="submit" class="w-full py-3 bg-white text-[#337C3E] font-extrabold text-lg rounded-xl hover:bg-gray-100 transition shadow-lg">
                Register
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-white text-sm">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-cyan-400 font-semibold hover:underline">Login disini</a></p>
        </div>
    </div>

</body>
</html>