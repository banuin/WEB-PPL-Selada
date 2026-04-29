{{-- resources/views/pelanggan/artikel.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artikel - Seladaku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-[#337C3E] mb-6">Artikel</h1>

    <div class="space-y-5">
        @forelse($artikels as $artikel)
        <a href="{{ route('artikel.show', $artikel) }}"
           class="flex gap-4 bg-white rounded-2xl shadow-sm hover:shadow-md transition p-4 items-center">
            @if($artikel->gambar)
                <img src="{{ Storage::url($artikel->gambar) }}" class="w-24 h-20 object-cover rounded-xl flex-shrink-0">
            @else
                <div class="w-24 h-20 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="text-green-400 text-xs">No Image</span>
                </div>
            @endif
            <div>
                <h2 class="font-semibold text-gray-700 text-sm leading-snug">{{ $artikel->judul }}</h2>
                <p class="text-xs text-gray-400 mt-1">{{ $artikel->created_at->format('d M Y') }}</p>
                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ Str::limit(strip_tags($artikel->konten), 80) }}</p>
            </div>
        </a>
        @empty
        <p class="text-center text-gray-400 py-12">Belum ada artikel.</p>
        @endforelse
    </div>
</div>

</body>
</html>