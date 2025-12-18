<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About HABA NEWS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css?family=Inter:wght@400;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; }
        .bg-primary-dark { background-color: #3b3b58; }
        .btn-yellow { background-color: #dcb14a; color: #3b3b58; }
        .bg-gold-custom { background-color: #d99b3e; }
    </style>
</head>
<body>

    {{-- NAVBAR UPDATE: Menambahkan Logika Auth & Dropdown --}}
    <nav class="bg-primary-dark text-white py-4 sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <a href="{{ route('beranda') }}" class="text-2xl font-bold text-yellow-500">HABA NEWS</a>

            <div class="flex items-center space-x-6 font-medium">
                <a href="{{ route('beranda') }}" class="hover:text-yellow-400 transition">Beranda</a>
                <a href="{{ route('about') }}" class="text-yellow-400 border-b-2 border-yellow-400 pb-1">About</a>

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
                            <button type="button" onclick="toggleDropdown()" class="flex items-center space-x-2 focus:outline-none" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=dcb14a&color=3b3b58" 
                                     alt="Profile" 
                                     class="h-9 w-9 rounded-full object-cover border-2 border-yellow-500">
                                <span class="text-white font-semibold hidden md:block">{{ Str::limit(auth()->user()->name, 10) }}</span>
                                <i class="fas fa-chevron-down text-xs text-yellow-400"></i>
                            </button>
                        </div>

                        {{-- Isi Dropdown --}}
                        <div id="profile-dropdown" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu">
                            <div class="py-1">
                                {{-- Link ke Ganti Password (Profile Edit) --}}
                                <a href="{{ route('profile.edit') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem">
                                    <i class="fas fa-key mr-2 text-gray-400"></i> Ganti Password
                                </a>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-red-600 block w-full text-left px-4 py-2 text-sm hover:bg-red-50" role="menuitem">
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

    {{-- Script untuk Dropdown --}}
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