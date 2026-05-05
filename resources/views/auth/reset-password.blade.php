<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAFAFA] font-sans antialiased text-gray-800 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Buat Password Baru</h1>
            <p class="text-[14px] text-gray-500">Cek kotak masuk email Anda dan masukkan 6 digit kode OTP beserta password baru Anda di bawah ini.</p>
        </div>

        <!-- Notifikasi Sukses dari halaman sebelumnya -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-[13px] font-medium text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Pesan Error Umum -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-[13px] font-medium">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            
            <!-- Email (Hidden/Readonly) agar user tidak repot ketik lagi -->
            <input type="hidden" name="email" value="{{ request()->query('email') }}">

            <div class="mb-5">
                <label for="otp" class="block text-[13px] font-medium text-gray-700 mb-2">Kode OTP (6 Digit)</label>
                <input type="text" id="otp" name="otp" required maxlength="6" autofocus
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#2F8540] focus:border-[#2F8540] text-[16px] tracking-[0.5em] text-center font-bold transition-all outline-none" 
                    placeholder="------">
            </div>

            <div class="mb-5">
                <label for="password" class="block text-[13px] font-medium text-gray-700 mb-2">Password Baru</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#2F8540] focus:border-[#2F8540] text-[14px] transition-all outline-none" 
                    placeholder="Masukkan password baru">
            </div>

            <div class="mb-8">
                <label for="password_confirmation" class="block text-[13px] font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#2F8540] focus:border-[#2F8540] text-[14px] transition-all outline-none" 
                    placeholder="Ulangi password baru">
            </div>

            <button type="submit" class="w-full bg-[#2F8540] hover:bg-[#246631] text-white py-2.5 rounded-lg text-[14px] font-bold transition shadow-sm mb-4">
                Simpan Password Baru
            </button>
        </form>

    </div>

</body>
</html>