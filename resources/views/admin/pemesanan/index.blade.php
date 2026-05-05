</html><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Pemesanan - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAFAFA] font-sans antialiased text-gray-800 p-8 md:p-12 min-h-screen">

    <div class="max-w-6xl mx-auto">
        
        <!-- Header Halaman (Panah Kembali & Judul) -->
        <div class="flex items-center mb-8">
            <a href="{{ route('admin.dashboard') }}" class="mr-4 text-black hover:text-gray-600 transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-black tracking-wide">Pemesanan</h1>
        </div>

        <!-- Container Card Putih -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            
            <!-- Judul & Tombol Riwayat -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">Daftar Pemesanan</h2>
                <a href="{{ route('admin.pemesanan.riwayat') }}" class="bg-[#2F8540] hover:bg-[#246631] text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm">
                    Riwayat
                </a>
            </div>

            <!-- Tabel Pemesanan -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr class="bg-[#EAF3EA]">
                            <th class="py-4 px-6 font-semibold text-gray-800 rounded-l-xl w-16">No</th>
                            <th class="py-4 px-6 font-semibold text-gray-800">Nama</th>
                            <th class="py-4 px-6 font-semibold text-gray-800">No.Telepon</th>
                            <th class="py-4 px-6 font-semibold text-gray-800">Status Pemesanan</th>
                            <th class="py-4 px-6 font-semibold text-gray-800 rounded-r-xl"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data dummy untuk memperlihatkan desain --}}
                        @for ($i = 1; $i <= 2; $i++)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="py-5 px-6 text-gray-800 font-medium">0{{ $i }}</td>
                            <td class="py-5 px-6 text-gray-800 font-medium">Bang Messi</td></td>
                            <td class="py-5 px-6 text-gray-800 font-medium">087449320832</td>
                            <td class="py-5 px-6">
                                <!-- Badge Status -->
                                <span class="inline-block px-5 py-1.5 border border-[#F59E0B] text-[#F59E0B] rounded-full text-[13px] font-semibold bg-orange-50/50">
                                    Diproses
                                </span>
                            </td>
                            <td class="py-5 px-6 text-right">
                                <a href="{{ route('admin.pemesanan.show') }}" class="inline-block bg-[#2F8540] text-white px-5 py-2.5 rounded-lg text-[13px] font-bold hover:bg-[#246631] transition shadow-sm">
                                Lihat Detail Pemesanan
                            </a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</body>
</html>