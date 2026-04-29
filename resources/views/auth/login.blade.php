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
<body class="bg-white font-['Poppins'] antialiased flex items-center justify-center min-h-screen">

    <div class="w-full max-w-5xl flex flex-col md:flex-row min-h-screen md:min-h-0 md:rounded-2xl overflow-hidden">

        <div class="w-full md:w-3/5 h-56 sm:h-72 md:h-auto md:min-h-[700px] flex-shrink-0">
            <img src="{{ asset('images/aset-selada.jpg') }}" alt="Selada"
                class="w-full h-full object-cover md:rounded-2xl">
        </div>
        <div class="w-full md:w-1/2 flex flex-col justify-center px-8 sm:px-12 md:px-14 py-10 md:py-16">
            @if(session('success'))
                <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40"></div>

                <div class="fixed inset-0 flex items-center justify-center z-50">
                    <div class="bg-green-500 text-white px-8 py-4 rounded-xl shadow-lg font-semibold">
                        {{ session('success') }}
                    </div>
                </div>

                <script>
                    setTimeout(function() {
                        @if(session('role') == 'admin')
                            window.location.href = "{{ route('admin.dashboard') }}";
                        @else
                            window.location.href = "{{ route('pelanggan.home') }}";
                        @endif
                    }, 500);
                </script>
            @endif
            <h2 class="text-3xl font-extrabold text-gray-700 mb-10">Seladaku</h2>
            <form action="{{ route('login.proses') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Username</label>
                    <input type="text" name="username"
                        class="w-full px-4 py-3 border border-gray-400 rounded-2xl focus:outline-none focus:border-[#337C3E] focus:ring-1 focus:ring-[#337C3E] text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-3 border border-gray-400 rounded-2xl focus:outline-none focus:border-[#337C3E] focus:ring-1 focus:ring-[#337C3E] text-sm">
                </div>
                @if(session('error'))
                    <p class="text-red-500 text-sm mt-1">
                        {{ session('error') }}
                    </p>
                @endif

                <button type="submit"
                    class="w-full py-3 mt-2 bg-[#337C3E] text-white font-bold rounded-2xl hover:bg-green-800 transition text-base tracking-wide">
                    Login
                </button>
            </form>

            <div class="text-center mt-4 mb-5">
                <a href="#" class="text-sm text-gray-500 hover:text-green-700">Reset Password?</a>
            </div>

            <a href="{{ route('register') }}"
                class="block text-center w-full py-3 border border-gray-500 text-gray-700 font-semibold rounded-2xl hover:bg-gray-50 transition text-sm">
                Create new account
            </a>

        </div>
    </div>

</body>
</html>