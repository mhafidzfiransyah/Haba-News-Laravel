<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HABA NEWS - {{ $activeCategory ?? 'Beranda' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; }
        .font-serif-heading { font-family: 'Merriweather', serif; }
        .bg-primary-dark { background-color: #3b3b58; } 
        .btn-yellow { background-color: #dcb14a; color: #3b3b58; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="bg-primary-dark text-white py-4 sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <a href="{{ route('beranda') }}" class="text-2xl font-bold text-yellow-500">HABA NEWS</a>
            <div class="hidden md:flex flex-1 mx-10 max-w-lg relative">
                <input type="text" placeholder="Search" class="w-full py-2 px-4 rounded-full text-gray-700 focus:outline-none shadow-inner">
                <button class="absolute right-3 top-2.5 text-gray-400"><i class="fas fa-search"></i></button>
            </div>
            <div class="flex items-center space-x-6 font-medium">
                <a href="{{ route('beranda') }}" class="hover:text-yellow-400 border-b-2 border-yellow-400 pb-1">Beranda</a>
                <a href="{{ route('about') }}" class="hover:text-yellow-400 transition">About</a>
                <a href="#" class="hover:text-yellow-400 transition">Contact</a>
                <a href="#" class="btn-yellow px-6 py-2 rounded font-bold hover:brightness-110 transition shadow">Login</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8 max-w-6xl">

        {{-- HERO SECTION --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
            <div class="lg:col-span-2 bg-gray-100 rounded-xl overflow-hidden shadow-sm group flex flex-col relative">
                <a href="{{ route('berita.detail', ['id' => $heroNews['id']]) }}" class="block w-full h-64 md:h-96 relative overflow-hidden">
                     <img src="{{ $heroNews['image'] }}" alt="Hero" class="w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-in-out">
                </a>
                <div class="p-6 bg-gray-200 flex-1">
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded flex items-center shadow-sm">
                            <i class="fas fa-check-circle mr-1"></i> Verified
                        </span>
                        <span class="text-gray-500 text-sm font-semibold">{{ $heroNews['category'] }}</span>
                    </div>
                    <a href="{{ route('berita.detail', ['id' => $heroNews['id']]) }}">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 font-serif-heading hover:text-blue-600 transition">{{ $heroNews['title'] }}</h2>
                    </a>
                    <p class="text-gray-600 text-sm md:text-base line-clamp-2">{{ $heroNews['desc'] }}</p>
                </div>
            </div>

            <div class="flex flex-col space-y-6">
                @foreach($subHeroNews as $item)
                <div class="bg-gray-200 rounded-xl overflow-hidden shadow-sm flex flex-col h-full group">
                    <a href="{{ route('berita.detail', ['id' => $item['id']]) }}" class="block w-full h-40 relative overflow-hidden">
                        <img src="{{ $item['image'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </a>
                    <div class="p-4 flex-1">
                        <div class="flex space-x-2 mb-1 items-center">
                             @if($item['verified'])
                             <span class="bg-green-500 text-white text-[10px] font-bold px-1 rounded shadow-sm">Verified</span>
                             @endif
                             <span class="text-gray-500 text-[10px] font-semibold">{{ $item['category'] }}</span>
                        </div>
                        <a href="{{ route('berita.detail', ['id' => $item['id']]) }}">
                            <h3 class="font-bold text-gray-800 text-sm leading-tight mb-1 hover:text-blue-600 transition">{{ $item['title'] }}</h3>
                        </a>
                        <p class="text-gray-500 text-xs line-clamp-2">{{ $item['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- KATEGORI --}}
        <div class="flex space-x-3 overflow-x-auto hide-scroll mb-10 pb-2">
            <a href="{{ route('beranda') }}" 
               class="{{ ($activeCategory ?? 'Semua') === 'Semua' ? 'bg-blue-500 text-white shadow-md' : 'bg-gray-200 text-gray-600 hover:bg-gray-300' }} px-6 py-2 rounded-full text-sm font-medium whitespace-nowrap transition">
               Semua
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('kategori', ['slug' => strtolower($cat)]) }}" 
                   class="{{ strtolower($activeCategory ?? '') === strtolower($cat) ? 'bg-blue-500 text-white shadow-md' : 'bg-gray-200 text-gray-600 hover:bg-gray-300' }} px-6 py-2 rounded-full text-sm font-medium whitespace-nowrap transition">
                    {{ $cat }}
                </a>
            @endforeach
            <button class="bg-gray-200 text-gray-600 px-4 py-2 rounded-full text-sm hover:bg-gray-300">......</button>
        </div>

        {{-- JUDUL SECTION --}}
        <div class="border-b-2 border-gray-200 mb-6">
            <h2 class="text-2xl font-serif-heading font-bold text-gray-800 inline-block border-b-4 border-gray-800 pb-2">
                @if(($activeCategory ?? 'Semua') === 'Semua')
                    Berita Terbaru
                @else
                    Kategori: {{ $activeCategory }}
                @endif
            </h2>
        </div>

        {{-- LIST BERITA --}}
        <div class="space-y-6">
            @forelse($newsList as $news)
            <div class="bg-gray-200 rounded-xl p-0 md:p-4 shadow-sm flex flex-col md:flex-row gap-0 md:gap-6 overflow-hidden md:overflow-visible hover:shadow-md transition group">
                <a href="{{ route('berita.detail', ['id' => $news['id']]) }}" class="w-full md:w-1/3 h-48 md:h-auto md:aspect-video relative flex-shrink-0 overflow-hidden md:rounded-lg block">
                     <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </a>
                <div class="w-full md:w-2/3 p-4 md:p-0 flex flex-col justify-center">
                    <div class="flex items-center space-x-2 mb-2">
                        @if(isset($news['verified']) && $news['verified'])
                        <span class="bg-green-500 text-white text-xs font-bold px-2 py-0.5 rounded flex items-center shadow-sm">
                            <i class="fas fa-check-circle mr-1 text-[10px]"></i> Verified
                        </span>
                        @endif
                        <span class="text-gray-500 text-sm font-semibold">{{ $news['category'] }}</span>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 leading-snug hover:text-blue-600 transition cursor-pointer">
                        <a href="{{ route('berita.detail', ['id' => $news['id']]) }}">
                            {{ $news['title'] }}
                        </a>
                    </h3>
                    <p class="text-gray-700 text-sm leading-relaxed line-clamp-3">
                        {{ $news['desc'] }}
                    </p>
                </div>
            </div>
            @empty
            <div class="text-center py-20 text-gray-500">
                <i class="fas fa-newspaper text-4xl mb-3 text-gray-300"></i>
                <p>Belum ada berita di halaman ini.</p>
            </div>
            @endforelse
        </div>

        {{-- PAGINATION DINAMIS --}}
        @if($totalPages > 1)
        <div class="flex justify-center mt-12 space-x-2">
            
            {{-- Tombol Loop Halaman --}}
            @for($i = 1; $i <= $totalPages; $i++)
                {{-- Logika URL: Jika Kategori aktif, link-nya ke kategori, jika tidak ke home biasa --}}
                @php
                    $url = ($activeCategory === 'Semua') 
                           ? route('beranda', ['page' => $i]) 
                           : route('kategori', ['slug' => strtolower($activeCategory), 'page' => $i]);
                @endphp

                <a href="{{ $url }}" 
                   class="w-10 h-10 flex items-center justify-center rounded font-bold transition {{ $page == $i ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-200 text-gray-600 hover:bg-gray-300' }}">
                   {{ $i }}
                </a>
            @endfor

        </div>
        @endif

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