<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pemesanan - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAFAFA] font-sans antialiased text-gray-800 p-8 md:p-12 min-h-screen">

    <div class="max-w-6xl mx-auto">
        
        <div class="flex items-center mb-8">
            <a href="{{ route('admin.pemesanan.index') }}" class="mr-4 text-black hover:text-gray-600 transition" title="Kembali ke Daftar Pemesanan">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-black tracking-wide">Pemesanan</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            
            <!-- Judul & Keterangan Halaman -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Riwayat Pemesanan</h2>
                    <p class="text-sm text-gray-500 mt-1">Menampilkan semua pesanan yang telah selesai dikonfirmasi dan dikirim.</p>
                </div>
            </div>
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
                    <tbody class="text-sm">
                        @forelse($pemesanans as $index => $item)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-5 px-6 font-medium text-gray-700">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-5 px-6 text-gray-800">{{ $item->pelanggan->name }}</td>
                            <td class="py-5 px-6 text-gray-800">{{ $item->pelanggan->nomor_telpon }}</td>
                            <td class="py-5 px-6 text-center">
                                <span class="inline-block px-5 py-1.5 border border-green-300 text-green-700 bg-green-50 rounded-full text-[13px] font-semibold">
                                    {{ $item->status_pembayaran }}
                                </span>
                            </td>
                            <td class="py-5 px-6 text-right">
                                <a href="{{ route('admin.pemesanan.show', $item->id) }}" class="inline-block bg-[#2F8540] text-white px-5 py-2.5 rounded-lg text-[13px] font-bold hover:bg-[#246631] transition shadow-sm">
                                    Lihat Detail Pemesanan
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-gray-400 italic">Belum ada riwayat pemesanan yang selesai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</body>
</html>