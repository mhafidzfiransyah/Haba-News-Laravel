<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About HABA NEWS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; }
        .bg-primary-dark { background-color: #3b3b58; }
        .btn-yellow { background-color: #dcb14a; color: #3b3b58; }
        .bg-gold-custom { background-color: #d99b3e; }
    </style>
</head>
<body>
    <nav class="bg-primary-dark text-white py-4 sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <a href="{{ route('beranda') }}" class="text-2xl font-bold text-yellow-500">HABA NEWS</a>
            <div class="flex items-center space-x-6 font-medium">
                <a href="{{ route('beranda') }}" class="hover:text-yellow-400 transition">Beranda</a>
                <a href="{{ route('about') }}" class="text-yellow-400 border-b-2 border-yellow-400 pb-1">About</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-12 max-w-5xl text-center">
        <h1 class="text-4xl md:text-5xl font-black text-black mb-8 tracking-wide">HABA NEWS</h1>
        <div class="max-w-3xl mx-auto mb-16">
            <p class="text-lg md:text-xl text-gray-800 leading-relaxed font-medium">
                "Selamat datang di Haba News, portal berita independen yang berkomitmen untuk menyajikan informasi yang cepat, akurat, dan berimbang."
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 px-4">
            {{-- KARTU VISI --}}
            <div class="relative pt-6 group">
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 bg-primary-dark text-white px-8 py-2 rounded-full font-bold text-lg z-10 shadow-md">VISI</div>
                <div class="bg-gold-custom text-white p-8 pt-12 rounded-[2.5rem] text-center h-full flex items-center justify-center hover:scale-105 transition duration-500">
                    <p class="font-medium leading-loose">"Menjadi media online pilihan di Indonesia yang dikenal karena kejujurannya."</p>
                </div>
            </div>
            {{-- KARTU MISI --}}
            <div class="relative pt-6 group">
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 bg-primary-dark text-white px-8 py-2 rounded-full font-bold text-lg z-10 shadow-md">MISI</div>
                <div class="bg-gold-custom text-white p-8 pt-12 rounded-[2.5rem] text-center h-full flex items-center justify-center hover:scale-105 transition duration-500">
                    <p class="font-medium leading-loose">"Menggali fakta, menyajikan sudut pandang, dan menghadirkan cerita relevan."</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>