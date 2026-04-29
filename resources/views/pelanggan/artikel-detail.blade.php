{{-- resources/views/pelanggan/artikel-detail.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $artikel->judul }} - Seladaku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F3F4F6] p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-lg p-8">
        <a href="javascript:history.back()" class="mb-4 inline-block text-gray-600">← Kembali</a>
        <h1 class="text-2xl font-bold text-center mb-6">{{ $artikel->title }}</h1>
        <img src="{{ asset('images/articles/'.$article->image) }}" class="w-full rounded-2xl mb-8 object-cover">
        <div class="prose max-w-none text-gray-700 leading-relaxed">
            {!! nl2br(e($artikel->content)) !!}
        </div>
    </div>
</body>
</html>