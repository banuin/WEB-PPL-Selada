<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog - Admin SELADAKU</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAFAFA] font-sans antialiased text-gray-800">

    <div class="max-w-7xl mx-auto px-6 py-10">

        <div class="flex justify-between items-center mb-8">
            
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-black transition flex items-center p-2 -ml-2">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>

            <a href="{{ route('admin.katalog.create') }}" class="bg-[#2F8540] hover:bg-[#246631] text-white px-4 py-2.5 rounded-lg flex items-center gap-2 text-sm font-medium transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="4"></rect>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"></path>
                </svg>
                Tambah katalog
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            {{-- Looping Data Dummy --}}
            @for ($i = 0; $i < 3; $i++)
            <div class="bg-white p-4 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 flex flex-col h-full">
                
                <img src="{{ asset('images/aset-selada.jpg') }}" alt="Selada" class="w-full h-48 object-cover rounded-xl mb-5">

                <h3 class="text-[15px] font-bold text-gray-800 leading-snug mb-8 pr-4">
                    Selada Paket Reseler/Tengkulak<br>
                    (minim 10Kg)
                </h3>

                <p class="text-[#2F8540] font-bold text-[15px] mt-auto">
                    Rp.000.000
                </p>
                
            </div>
            @endfor

        </div>

    </div>

</body>
</html>