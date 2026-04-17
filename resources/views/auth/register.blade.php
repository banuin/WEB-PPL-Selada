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
        
        <form action="#" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-white mb-2">Username</label>
                    <input type="text" class="w-full px-4 py-2.5 bg-transparent border border-white rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-white/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white mb-2">Nama Lengkap</label>
                    <input type="text" class="w-full px-4 py-2.5 bg-transparent border border-white rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-white/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white mb-2">Email</label>
                    <input type="email" class="w-full px-4 py-2.5 bg-transparent border border-white rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-white/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white mb-2">No. Telepon</label>
                    <input type="text" class="w-full px-4 py-2.5 bg-transparent border border-white rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-white/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white mb-2">Alamat</label>
                    <input type="text" class="w-full px-4 py-2.5 bg-transparent border border-white rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-white/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white mb-2">Password</label>
                    <input type="password" class="w-full px-4 py-2.5 bg-transparent border border-white rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-white/50">
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