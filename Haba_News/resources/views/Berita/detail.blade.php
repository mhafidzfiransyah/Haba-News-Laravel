<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news['title'] }} - HABA NEWS</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; }
        .font-serif-heading { font-family: 'Merriweather', serif; }
        .bg-primary-dark { background-color: #3b3b58; } 
        .btn-yellow { background-color: #dcb14a; color: #3b3b58; }
        .article-content p { margin-bottom: 1.5rem; line-height: 1.8; color: #374151; }
        
        /* Custom Scroll untuk komentar jika panjang */
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
    </style>
</head>
<body>

    <nav class="bg-primary-dark text-white py-4 sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <a href="{{ route('beranda') }}" class="text-2xl font-bold text-yellow-500">HABA NEWS</a>
            <div class="hidden md:flex flex-1 mx-10 max-w-lg relative">
                <input type="text" placeholder="Search" class="w-full py-2 px-4 rounded-full text-gray-700 focus:outline-none">
                <button class="absolute right-3 top-2.5 text-gray-400"><i class="fas fa-search"></i></button>
            </div>
            <div class="flex items-center space-x-6 font-medium">
                <a href="{{ route('beranda') }}" class="hover:text-yellow-400">Beranda</a>
                <a href="#" class="hover:text-yellow-400">About</a>
                <a href="#" class="hover:text-yellow-400">Contact</a>
                <a href="#" class="btn-yellow px-6 py-2 rounded font-bold hover:brightness-110 transition">Login</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8 max-w-7xl">

        {{-- BREADCRUMB --}}
        <div class="text-sm text-gray-500 mb-6">
            <a href="{{ route('beranda') }}" class="hover:text-blue-600">Beranda</a> 
            <span class="mx-2">></span> 
            <a href="{{ route('kategori', strtolower($news['category'])) }}" class="hover:text-blue-600">{{ $news['category'] }}</a> 
            <span class="mx-2">></span> 
            <span class="text-gray-800 font-medium truncate">{{ \Illuminate\Support\Str::limit($news['title'], 50) }}</span>
        </div>

        {{-- GRID LAYOUT: 8 Kolom Kiri (Konten), 4 Kolom Kanan (Sidebar) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            {{-- KOLOM KIRI (KONTEN BERITA) - Span 8 --}}
            <div class="lg:col-span-8">
                
                {{-- Badge --}}
                <div class="flex items-center space-x-2 mb-3">
                    @if($news['verified'])
                    <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded flex items-center shadow-sm">
                        <i class="fas fa-check-circle mr-1"></i> Verified
                    </span>
                    @endif
                    <span class="text-gray-500 text-sm font-semibold">{{ $news['category'] }}</span>
                </div>

                {{-- Judul --}}
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-serif-heading leading-tight">
                    {{ $news['title'] }}
                </h1>

                {{-- Author --}}
                <div class="flex items-center mb-6">
                    <img src="{{ $news['author_avatar'] }}" alt="Author" class="w-12 h-12 rounded-full mr-4 bg-gray-200 border border-gray-300">
                    <div>
                        <div class="text-base font-bold text-gray-800">{{ $news['author'] }}</div>
                        <div class="text-xs text-gray-500 flex items-center mt-0.5">
                            <span>{{ $news['date'] }}</span>
                            <span class="mx-2 text-gray-300">•</span>
                            <span><i class="fas fa-eye mr-1"></i> {{ $news['views'] }}</span>
                        </div>
                    </div>
                </div>

                {{-- Gambar Utama --}}
                <div class="w-full mb-8 rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                    {{-- Menjaga rasio gambar --}}
                    <img src="{{ $news['image'] }}" alt="Main News" class="w-full h-auto object-cover block">
                </div>

                {{-- Isi Konten --}}
                <div class="article-content text-lg text-gray-800 leading-relaxed mb-10 border-b border-gray-200 pb-10">
                    {!! $news['content'] !!}
                </div>
                
            </div>

            {{-- KOLOM KANAN (SIDEBAR) - Span 4 --}}
            <div class="lg:col-span-4 space-y-8">
                
                {{-- 1. CARD KOMENTAR --}}
                <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 p-6 overflow-hidden">
                    <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-2">
                        <h3 class="text-lg font-bold text-gray-800 font-serif-heading">Komentar ({{ count($comments) }})</h3>
                    </div>
                    
                    <div class="mb-6">
                        <textarea placeholder="Tuliskan Komentar Anda..." class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 focus:outline-none focus:border-blue-500 text-sm h-24 resize-none mb-2 transition"></textarea>
                        <button class="btn-yellow text-primary-dark font-bold py-2 px-4 rounded text-sm hover:opacity-90 w-full transition shadow-sm">
                            <i class="fas fa-paper-plane mr-1"></i> Kirim
                        </button>
                    </div>

                    {{-- Wrapper Scroll Komentar --}}
                    <div class="space-y-6 max-h-[500px] overflow-y-auto custom-scroll pr-2">
                        @foreach($comments as $comment)
                        <div class="flex space-x-3">
                            <img src="{{ $comment['avatar'] }}" class="w-8 h-8 rounded-full bg-gray-200 flex-shrink-0 object-cover border border-gray-200">
                            <div class="flex-1 bg-gray-50 p-3 rounded-lg rounded-tl-none">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="font-bold text-sm text-gray-800">{{ $comment['name'] }}</h4>
                                    <span class="text-[10px] text-gray-400">{{ $comment['time'] }}</span>
                                </div>
                                <p class="text-xs text-gray-600 leading-relaxed">{{ $comment['text'] }}</p>
                                <div class="flex items-center space-x-3 mt-2 text-[10px] text-gray-500 font-medium">
                                    <a href="#" class="hover:text-blue-600">Balas</a>
                                    <a href="#" class="hover:text-red-600">Laporkan</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- 2. CARD BERITA SERUPA --}}
                <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 font-serif-heading border-b border-gray-100 pb-2">Berita Serupa</h3>
                    <div class="space-y-4">
                        @foreach($relatedNews as $related)
                        {{-- Item Berita Kecil --}}
                        <a href="#" class="flex space-x-3 group cursor-pointer p-2 hover:bg-gray-50 rounded-lg transition">
                            <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0 bg-gray-200">
                                <img src="{{ $related['image'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            </div>
                            <div class="flex flex-col justify-center">
                                <div class="flex items-center space-x-1 mb-1">
                                    @if($related['verified'])
                                    <span class="bg-green-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-sm">Verified</span>
                                    @endif
                                    <span class="text-gray-400 text-[10px] font-medium">{{ $related['category'] }}</span>
                                </div>
                                <h4 class="font-bold text-sm text-gray-800 leading-snug group-hover:text-blue-600 transition line-clamp-2">{{ $related['title'] }}</h4>
                            </div>
                        </a>
                        @endforeach
                    </div>
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