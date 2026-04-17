<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SELADAKU</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased flex items-center justify-center min-h-screen p-6">
    
    <div class="max-w-5xl w-full flex flex-col md:flex-row bg-white rounded-2xl overflow-hidden gap-8 items-center">
        <div class="w-full md:w-1/2 h-64 md:h-[500px] rounded-2xl overflow-hidden shadow-lg">
            <img src="{{ asset('images/aset-selada.jpg') }}" alt="Selada" class="w-full h-full object-cover">
        </div>

        <div class="w-full md:w-1/2 px-4 md:pr-8 py-8">
            <h2 class="text-3xl font-extrabold text-gray-700 mb-8">Seladaku</h2>

            <form action="{{ route('login.proses') }}" method="POST" class="space-y-5">
                @csrf
                <!-- <button type="submit" class="w-full py-3 mt-4 bg-[#337C3E] text-white font-bold rounded-xl hover:bg-green-800 transition shadow-md">
                    Login -->
                </button>
            </form>
            
            <form action="#" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Username</label>
                    <input type="text" class="w-full px-4 py-2.5 border border-gray-600 rounded-xl focus:outline-none focus:border-[#337C3E] focus:ring-1 focus:ring-[#337C3E]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                    <input type="password" class="w-full px-4 py-2.5 border border-gray-600 rounded-xl focus:outline-none focus:border-[#337C3E] focus:ring-1 focus:ring-[#337C3E]">
                </div>
                
                <button type="submit" class="w-full py-3 mt-4 bg-[#337C3E] text-white font-bold rounded-xl hover:bg-green-800 transition shadow-md">
                    Login
                </button>
            </form>
<!-- 
            <div class="text-center mt-4 mb-6">
                <a href="#" class="text-sm text-gray-500 hover:text-green-700">Reset Password?</a>
            </div>

            <div>
                <a href="{{ route('register') }}" class="block text-center w-full py-3 border-2 border-gray-600 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition">
                    Create new account
                </a>
            </div>
        </div>
    </div> -->

</body>
</html>