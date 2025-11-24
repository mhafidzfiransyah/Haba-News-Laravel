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
        body { font-family: 'Inter', sans-serif; }
        .font-serif-heading { font-family: 'Merriweather', serif; }
        .bg-primary-dark { background-color: #3b3b58; }
        .btn-yellow { background-color: #dcb14a; color: #3b3b58; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-white">

    {{-- NAVBAR --}}
    <nav class="bg-primary-dark text-white py-4 sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <a href="{{ route('beranda') }}" class="text-2xl font-bold text-yellow-500">HABA NEWS</a>
            
            <form action="{{ route('beranda') }}" method="GET" class="hidden md:flex flex-1 mx-10 max-w-lg relative">
                <input type="text" name="q" placeholder="Cari berita..." value="{{ request('q') }}" class="w-full py-2 px-4 rounded-full text-gray-700 focus:outline-none shadow-inner">
                <button type="submit" class="absolute right-3 top-2.5 text-gray-400"><i class="fas fa-search"></i></button>
            </form>

            <div class="flex items-center space-x-6 font-medium">
                <a href="{{ route('beranda') }}" class="text-yellow-400 border-b-2 border-yellow-400 pb-1">Beranda</a>
                <a href="{{ route('about') }}" class="hover:text-yellow-400 transition">About</a>
                {{-- JIKA BELUM LOGIN TAMPILKAN LOGIN --}}
                @guest
                    <a href="{{ route('login') }}" class="btn-yellow px-6 py-2 rounded font-bold">
                        Login
                    </a>
                @endguest

                <!-- jika sudah login akan tampil dashboard -->
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-yellow px-6 py-2 rounded font-bold">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="btn-yellow px-6 py-2 rounded font-bold">
                            Dashboard
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-9 max-w-9xl">
        
        {{-- HERO SECTION (Sekarang Selalu Muncul) --}}
        @if($heroNews)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
            {{-- Hero Utama --}}
            <div class="lg:col-span-2 bg-gray-100 rounded-xl overflow-hidden shadow-sm group flex flex-col relative">
                <a href="{{ route('berita.detail', $heroNews->id) }}" class="block w-full h-64 md:h-96 relative overflow-hidden">
                    <img src="{{ $heroNews->image }}" 
                         alt="Hero" 
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-700"
                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=600&auto=format&fit=crop';">
                </a>
                <div class="p-6 bg-gray-200 flex-1">
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded shadow-sm">HOT NEWS</span>
                        <span class="text-gray-500 text-sm font-semibold">{{ $heroNews->category }}</span>
                    </div>
                    <a href="{{ route('berita.detail', $heroNews->id) }}">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 font-serif-heading hover:text-blue-600 transition">{{ $heroNews->title }}</h2>
                    </a>
                    <p class="text-gray-600 text-sm md:text-base line-clamp-2">{{ $heroNews->desc }}</p>
                </div>
            </div>

            {{-- Sub Hero (Side) --}}
            <div class="flex flex-col space-y-6">
                @foreach($subHeroNews as $item)
                <div class="bg-gray-200 rounded-xl overflow-hidden shadow-sm flex flex-col h-full group">
                    <a href="{{ route('berita.detail', $item->id) }}" class="block w-full h-40 relative overflow-hidden">
                        <img src="{{ $item->image }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=600&auto=format&fit=crop';">
                    </a>
                    <div class="p-4 flex-1 flex flex-col justify-center">
                        <div class="flex space-x-2 mb-1 items-center">
                            <span class="text-gray-500 text-[10px] font-semibold uppercase tracking-wider">{{ $item->category }}</span>
                        </div>
                        <a href="{{ route('berita.detail', $item->id) }}">
                            <h3 class="font-bold text-gray-800 text-sm leading-snug mb-2 hover:text-blue-600 transition line-clamp-2">{{ $item->title }}</h3>
                        </a>
                        {{-- TAMBAHAN: Deskripsi untuk Sub-Hero --}}
                        <p class="text-gray-500 text-xs line-clamp-2 leading-relaxed">{{ $item->desc }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- KATEGORI SCROLL (Dengan Efek Fade Kiri Kanan) --}}
        <div class="relative mb-10">
            {{-- Gradient Kiri --}}
            <div class="absolute left-0 top-0 bottom-0 w-12 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
            
            {{-- Scroll Container --}}
            <div class="flex space-x-3 overflow-x-auto hide-scroll pb-2 px-4">
                <a href="{{ route('beranda') }}" class="{{ ($activeCategory === 'Semua') ? 'bg-blue-500 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} px-6 py-2 rounded-full text-sm font-medium whitespace-nowrap transition transform hover:scale-105">Semua</a>
                
                @foreach($categories as $cat)
                    <a href="{{ route('kategori', strtolower(str_replace(' ', '-', $cat))) }}" 
                       class="{{ strtolower($activeCategory) === strtolower($cat) ? 'bg-blue-500 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} px-6 py-2 rounded-full text-sm font-medium whitespace-nowrap transition transform hover:scale-105">
                       {{ $cat }}
                    </a>
                @endforeach
            </div>

            {{-- Gradient Kanan --}}
            <div class="absolute right-0 top-0 bottom-0 w-12 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>
        </div>

        {{-- JUDUL SECTION --}}
        <div class="border-b-2 border-gray-200 mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-serif-heading font-bold text-gray-800 inline-block border-b-4 border-gray-800 pb-2">
                @if(request('q')) Hasil Pencarian: "{{ request('q') }}"
                @elseif($activeCategory === 'Semua') Berita Terbaru
                @else Kategori: {{ $activeCategory }}
                @endif
            </h2>
        </div>

        {{-- LIST BERITA --}}
        <div class="space-y-6">
            @forelse($newsList as $news)
            <div class="bg-white border border-gray-100 rounded-xl p-0 md:p-4 shadow-sm flex flex-col md:flex-row gap-0 md:gap-6 overflow-hidden md:overflow-visible hover:shadow-md transition group">
                <a href="{{ route('berita.detail', $news->id) }}" class="w-full md:w-1/3 h-48 md:h-40 md:aspect-video relative flex-shrink-0 overflow-hidden md:rounded-lg block">
                    <img src="{{ $news->image }}" 
                         alt="{{ $news->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=600&auto=format&fit=crop';">
                </a>
                <div class="w-full md:w-2/3 p-4 md:p-0 flex flex-col justify-center">
                    <div class="flex items-center space-x-2 mb-2">
                        @if($news->is_verified)
                        <span class="bg-green-500 text-white text-[10px] font-bold px-2 py-0.5 rounded flex items-center shadow-sm"><i class="fas fa-check-circle mr-1"></i> Verified</span>
                        @endif
                        <span class="text-gray-500 text-xs font-bold uppercase tracking-wide">{{ $news->category }}</span>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 leading-snug hover:text-blue-600 transition cursor-pointer">
                        <a href="{{ route('berita.detail', $news->id) }}">{{ $news->title }}</a>
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-2 mb-3">{{ $news->desc }}</p>
                    <div class="text-xs text-gray-400 mt-auto flex items-center">
                        <i class="far fa-clock mr-1"></i> {{ $news->created_at->diffForHumans() }}
                        <span class="mx-2">•</span>
                        <i class="far fa-eye mr-1"></i> {{ $news->views }} Views
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-20 text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <i class="fas fa-newspaper text-4xl mb-3 text-gray-300"></i>
                <p>Belum ada berita di kategori <strong>{{ $activeCategory }}</strong>.</p>
                <a href="{{ route('beranda') }}" class="text-blue-600 underline mt-2 inline-block">Lihat Semua Berita</a>
            </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        <div class="mt-12 flex justify-center">
            {{ $newsList->withQueryString()->links('pagination::tailwind') }}
        </div>

    </main>

    <footer class="bg-primary-dark text-gray-300 py-12 mt-20 text-center">
        <p>&copy; 2025 Haba News. All rights reserved.</p>
    </footer>
</body>
</html>