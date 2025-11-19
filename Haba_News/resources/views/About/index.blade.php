<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - HABA NEWS</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; }
        .font-serif-heading { font-family: 'Merriweather', serif; }
        .bg-primary-dark { background-color: #3b3b58; } 
        .btn-yellow { background-color: #dcb14a; color: #3b3b58; }
        .bg-gold-custom { background-color: #d99b3e; } /* Warna kartu Visi Misi */
        .shadow-soft-gold { box-shadow: 0 10px 25px -5px rgba(217, 155, 62, 0.4); }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="bg-primary-dark text-white py-4 sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <a href="{{ route('beranda') }}" class="text-2xl font-bold text-yellow-500">HABA NEWS</a>
            
            {{-- Search Bar (Optional di halaman About, tapi kita biarkan agar konsisten) --}}
            <div class="hidden md:flex flex-1 mx-10 max-w-lg relative">
                <input type="text" placeholder="Search" class="w-full py-2 px-4 rounded-full text-gray-700 focus:outline-none">
                <button class="absolute right-3 top-2.5 text-gray-400"><i class="fas fa-search"></i></button>
            </div>

            <div class="flex items-center space-x-6 font-medium">
                <a href="{{ route('beranda') }}" class="hover:text-yellow-400 transition">Beranda</a>
                {{-- Menu About Aktif --}}
                <a href="{{ route('about') }}" class="text-yellow-400 border-b-2 border-yellow-400 pb-1">About</a>
                <a href="#" class="hover:text-yellow-400 transition">Contact</a>
                <a href="#" class="btn-yellow px-6 py-2 rounded font-bold hover:brightness-110 transition">Login</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-12 max-w-5xl">

        {{-- JUDUL UTAMA --}}
        <div class="text-center mb-10">
            <h1 class="text-4xl md:text-5xl font-black text-black mb-8 tracking-wide">HABA NEWS</h1>
            
            <div class="max-w-3xl mx-auto">
                <p class="text-lg md:text-xl text-gray-800 leading-relaxed font-medium">
                    "Selamat datang di Haba News, portal berita independen
                    yang berkomitmen untuk menyajikan informasi yang cepat, akurat,
                    dan berimbang bagi masyarakat Indonesia. Kami hadir untuk menjadi
                    sumber berita yang bisa Anda andalkan setiap hari."
                </p>
            </div>
        </div>

        {{-- VISI & MISI CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 mt-16 px-4">

            {{-- KARTU VISI --}}
            <div class="relative pt-6 group">
                {{-- Badge --}}
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 bg-primary-dark text-white px-8 py-2 rounded-full font-bold text-lg z-10 shadow-md">
                    VISI
                </div>
                {{-- Card Body --}}
                <div class="bg-gold-custom text-white p-8 pt-12 rounded-[2.5rem] text-center h-full shadow-soft-gold flex items-center justify-center hover:scale-105 transition duration-500">
                    <p class="font-medium text-sm md:text-base leading-loose">
                        "Visi kami adalah menjadi media online pilihan di
                        Indonesia yang dikenal karena kejujurannya,
                        ketidakberpihakannya, dan kontribusinya terhadap
                        masyarakat yang lebih terinformasi."
                    </p>
                </div>
            </div>

            {{-- KARTU MISI --}}
            <div class="relative pt-6 group">
                {{-- Badge --}}
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 bg-primary-dark text-white px-8 py-2 rounded-full font-bold text-lg z-10 shadow-md">
                    Misi
                </div>
                {{-- Card Body --}}
                <div class="bg-gold-custom text-white p-8 pt-12 rounded-[2.5rem] text-center h-full shadow-soft-gold flex items-center justify-center hover:scale-105 transition duration-500">
                    <p class="font-medium text-sm md:text-base leading-loose">
                        "Misi kami adalah menggali fakta, menyajikan
                        berbagai sudut pandang, dan menghadirkan cerita
                        yang relevan dengan integritas tinggi. Kami
                        berdedikasi untuk jurnalisme yang memberdayakan
                        pembaca."
                    </p>
                </div>
            </div>

        </div>

    </main>

    {{-- FOOTER --}}
    <footer class="bg-primary-dark text-gray-300 py-12 mt-20">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm mb-10">
            <div>
                <h3 class="text-yellow-500 text-xl font-bold mb-4">Haba News</h3>
                <p class="mb-4 opacity-80 leading-relaxed">Kabar yang disaring, bukan sekedar dikirim.</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4 text-lg">Katagori</h4>
                <ul class="space-y-2 opacity-80">
                    <li><a href="#" class="hover:text-yellow-400 transition">Politik</a></li>
                    <li><a href="#" class="hover:text-yellow-400 transition">Teknologi</a></li>
                    <li><a href="#" class="hover:text-yellow-400 transition">Ekonomi</a></li>
                    <li><a href="#" class="hover:text-yellow-400 transition">Kesehatan</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4 text-lg">Tentang</h4>
                <ul class="space-y-2 opacity-80">
                    <li><a href="{{ route('about') }}" class="text-yellow-400 font-bold">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-yellow-400 transition">Kebijakan Privasi Syarat & Ketetntuan</a></li>
                    <li><a href="#" class="hover:text-yellow-400 transition">Hubungan Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4 text-lg">Newsletter</h4>
                <p class="mb-4 opacity-80">Dapatkan berita terbaru langsung di inbox Anda</p>
            </div>
        </div>
        <div class="border-t border-gray-600 pt-6 text-center text-xs opacity-60">
            &copy; 2025 Haba News. All rights reserved
        </div>
    </footer>

</body>
</html>