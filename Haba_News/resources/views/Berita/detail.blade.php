<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }} - HABA NEWS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css?family=Inter:wght@400;500;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif-heading { font-family: 'Merriweather', serif; }
        .bg-primary-dark { background-color: #3b3b58; }
        .btn-yellow { background-color: #dcb14a; color: #3b3b58; }
        /* Styling khusus untuk konten artikel agar rapi */
        .article-content p { margin-bottom: 1.5rem; line-height: 1.8; color: #374151; }
        .article-content h3 { margin-top: 2rem; margin-bottom: 1rem; font-weight: 700; font-size: 1.25rem; color: #111827; }
        .article-content blockquote { border-left-width: 4px; border-color: #3b82f6; padding-left: 1rem; font-style: italic; color: #4b5563; margin-bottom: 1.5rem; background-color: #f9fafb; padding: 1rem; border-radius: 0 0.5rem 0.5rem 0; }
        .article-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.5rem; }
        .article-content li { margin-bottom: 0.5rem; }
    </style>
</head>
<body class="bg-white">

    {{-- NAVBAR --}}
    <nav class="bg-primary-dark text-white py-4 sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <a href="{{ route('beranda') }}" class="text-2xl font-bold text-yellow-500">HABA NEWS</a>

            <div class="flex items-center space-x-6 font-medium">
                <a href="{{ route('beranda') }}" class="hover:text-yellow-400 transition">Beranda</a>
                <a href="{{ route('about') }}" class="hover:text-yellow-400 transition">About</a>

                @guest
                    <a href="{{ route('login') }}" class="btn-yellow px-6 py-2 rounded font-bold">
                        Login
                    </a>
                @endguest

                @auth
                    {{-- Jika Admin, tampilkan tombol Dashboard --}}
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-400 transition mr-2">
                            Dashboard
                        </a>
                    @endif

                    {{-- DROPDOWN PROFIL --}}
                    <div class="relative inline-block text-left">
                        <div>
                            <button type="button" onclick="toggleDropdown()" class="flex items-center space-x-2 focus:outline-none" id="menu-button">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=dcb14a&color=3b3b58" 
                                     alt="Profile" 
                                     class="h-9 w-9 rounded-full object-cover border-2 border-yellow-500">
                                <span class="text-white font-semibold hidden md:block">{{ Str::limit(auth()->user()->name, 10) }}</span>
                                <i class="fas fa-chevron-down text-xs text-yellow-400"></i>
                            </button>
                        </div>

                        <div id="profile-dropdown" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="py-1">
                                {{-- Link ke Ganti Password --}}
                                <a href="{{ route('profile.edit') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100">
                                    <i class="fas fa-key mr-2 text-gray-400"></i> Ganti Password
                                </a>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-red-600 block w-full text-left px-4 py-2 text-sm hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8 max-w-7xl">
        {{-- Breadcrumb --}}
        <div class="text-sm text-gray-500 mb-6">
            <a href="{{ route('beranda') }}" class="hover:text-blue-600">Beranda</a> <span class="mx-2">></span>
            <a href="{{ route('kategori', strtolower($news->category)) }}" class="hover:text-blue-600">{{ $news->category }}</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            {{-- KOLOM KIRI (KONTEN) --}}
            <div class="lg:col-span-8">
                {{-- Badge --}}
                <div class="flex items-center space-x-2 mb-3">
                    @if($news->is_verified)
                    <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded flex items-center shadow-sm"><i class="fas fa-check-circle mr-1"></i> Verified</span>
                    @endif
                    <span class="text-gray-500 text-sm font-semibold">{{ $news->category }}</span>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-serif-heading leading-tight">{{ $news->title }}</h1>

                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 rounded-full bg-gray-200 mr-4 overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($news->author) }}" alt="Author" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <div class="text-base font-bold text-gray-800">{{ $news->author }}</div>
                        <div class="text-xs text-gray-500 flex items-center mt-0.5">
                            <span>{{ $news->created_at->format('d M Y, H:i') }} WIB</span>
                            <span class="mx-2 text-gray-300">|</span>
                            <span><i class="fas fa-eye mr-1"></i> {{ $news->views }} Views</span>
                        </div>
                    </div>
                </div>

                {{-- GAMBAR UTAMA --}}
                <div class="w-full mb-8 rounded-2xl overflow-hidden shadow-sm border border-gray-100 aspect-video">
                    <img src="{{ $news->image }}" alt="Main News" class="w-full h-full object-cover block" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=600&auto=format&fit=crop';">
                </div>

                <div class="article-content text-lg text-gray-800 leading-relaxed mb-10 border-b border-gray-200 pb-10">
                    {!! $news->content !!}
                </div>
            </div>

            {{-- KOLOM KANAN (SIDEBAR & KOMENTAR) --}}
            <div class="lg:col-span-4 space-y-8">
                {{-- FORM KOMENTAR --}}
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 font-serif-heading mb-4">Komentar ({{ count($comments) }})</h3>

                    @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-2 text-sm rounded mb-2">{{ session('success') }}</div>
                    @endif

                    <div class="mt-6 mb-4">
                        @auth
                        <form action="{{ route('berita.komentar', $news->id) }}" method="POST" class="space-y-2">
                            @csrf
                            <textarea name="text" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Tulis komentar..." rows="4" required></textarea>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Kirim
                            </button>
                        </form>
                        @else
                        <div class="border border-gray-300 bg-gray-50 p-4 rounded-lg text-center">
                            <p class="text-gray-700 mb-2">Anda harus login untuk menulis komentar.</p>
                            <a href="{{ route('login') }}" class="inline-block px-4 py-2 bg-primary-dark text-white rounded-lg hover:bg-indigo-700 transition">
                                Login Sekarang
                            </a>
                        </div>
                        @endauth
                    </div>

                    <div class="space-y-6 max-h-[500px] overflow-y-auto pr-2">
                        @forelse($comments as $comment)
                        <div class="flex space-x-3">
                            <img src="{{ $comment->avatar }}" class="w-8 h-8 rounded-full bg-gray-200 flex-shrink-0 object-cover">
                            <div class="flex-1 bg-gray-50 p-3 rounded-lg rounded-tl-none">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="font-bold text-sm text-gray-800">{{ $comment->name }}</h4>
                                    <span class="text-[10px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-gray-600 leading-relaxed">{{ $comment->text }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-gray-400 text-xs">Jadilah yang pertama berkomentar!</p>
                        @endforelse
                    </div>
                </div>

                {{-- BERITA SERUPA --}}
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 font-serif-heading border-b border-gray-100 pb-2">Berita Serupa</h3>
                    <div class="space-y-4">
                        @foreach($relatedNews as $related)
                        <a href="{{ route('berita.detail', $related->id) }}" class="flex space-x-3 group cursor-pointer p-2 hover:bg-gray-50 rounded-lg transition">
                            <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0 bg-gray-200">
                                <img src="{{ $related->image }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=600&auto=format&fit=crop';">
                            </div>
                            <div class="flex flex-col justify-center">
                                <span class="text-gray-400 text-[10px] font-medium mb-1">{{ $related->category }}</span>
                                <h4 class="font-bold text-sm text-gray-800 leading-snug group-hover:text-blue-600 line-clamp-2">{{ $related->title }}</h4>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("profile-dropdown");
            dropdown.classList.toggle("hidden");
        }
        window.onclick = function(event) {
            if (!event.target.closest('#menu-button')) {
                var dropdown = document.getElementById("profile-dropdown");
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            }
        }
    </script>
</body>
</html>