<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAFAFA] font-sans antialiased text-gray-800 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Lupa Password?</h1>
            <p class="text-[14px] text-gray-500">Masukkan email yang terdaftar. Kami akan mengirimkan 6 digit kode OTP untuk mereset password Anda.</p>
        </div>

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-[13px] font-medium">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="email" class="block text-[13px] font-medium text-gray-700 mb-2">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#2F8540] focus:border-[#2F8540] text-[14px] transition-all outline-none" 
                    placeholder="contoh@email.com">
                
                <!-- Pesan Error Validasi -->
                @error('email')
                    <p class="mt-2 text-[12px] text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#2F8540] hover:bg-[#246631] text-white py-2.5 rounded-lg text-[14px] font-bold transition shadow-sm mb-4">
                Kirim Kode OTP
            </button>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-[13px] font-semibold text-[#2F8540] hover:text-[#246631] transition">
                    Kembali ke halaman Login
                </a>
            </div>
        </form>

    </div>

</body>
</html>