<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - HABA NEWS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    {{-- Tambahkan Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .bg-sidebar { background-color: #3b3b58; }
        .text-gold { color: #dcb14a; }
        .active-nav { background-color: rgba(255,255,255,0.1); border-right: 4px solid #dcb14a; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-sidebar text-white flex flex-col shadow-xl z-20 hidden md:flex transition-all duration-300">
        <div class="h-16 flex items-center px-8 border-b border-gray-600">
            <h1 class="text-2xl font-bold text-gold tracking-wider">HABA <span class="text-white text-sm">ADMIN</span></h1>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.dashboard') ? 'active-nav' : '' }}">
                <i class="fas fa-tachometer-alt w-6"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('admin.berita') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.berita') ? 'active-nav' : '' }}">
                <i class="fas fa-newspaper w-6"></i>
                <span class="font-medium">Kelola Berita</span>
            </a>
            
            {{-- Menu Users Baru --}}
            <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.users') ? 'active-nav' : '' }}">
                <i class="fas fa-users w-6"></i>
                <span class="font-medium">Daftar User</span>
            </a>

            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Lainnya</p>
            
            <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition">
                <i class="fas fa-cog w-6"></i>
                <span class="font-medium">Pengaturan</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-600">
            <a href="{{ route('beranda') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:text-white transition">
                <i class="fas fa-sign-out-alt w-6"></i>
                <span>Ke Website Utama</span>
            </a>
        </div>
    </aside>

    {{-- MAIN WRAPPER --}}
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        {{-- HEADER --}}
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10">
            <div class="flex items-center">
                <button class="md:hidden text-gray-600 mr-4"><i class="fas fa-bars text-xl"></i></button>
                <h2 class="text-xl font-bold text-gray-800">@yield('title')</h2>
            </div>

            <div class="flex items-center space-x-6">
                
                {{-- Notifikasi Lonceng --}}
                <div class="relative cursor-pointer group">
                    <i class="far fa-bell text-xl text-gray-500 group-hover:text-blue-600 transition"></i>
                    {{-- Badge Merah --}}
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">3</span>
                    
                    {{-- Dropdown Notif (Hover) --}}
                    <div class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-100 hidden group-hover:block py-2 z-50">
                        <div class="px-4 py-2 border-b border-gray-100 text-sm font-bold text-gray-700">Laporan Terbaru</div>
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-50">
                            <div class="text-xs text-red-500 font-bold mb-1">Laporan Berita</div>
                            <p class="text-xs text-gray-600 truncate">User Budi melaporkan berita "Hoax..."</p>
                        </a>
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition">
                            <div class="text-xs text-red-500 font-bold mb-1">Laporan Komentar</div>
                            <p class="text-xs text-gray-600 truncate">User Siti melaporkan komentar SARA...</p>
                        </a>
                    </div>
                </div>

                {{-- Profil --}}
                <div class="flex items-center space-x-3 cursor-pointer">
                    <div class="text-right hidden md:block">
                        <div class="text-sm font-bold text-gray-800">Admin Ganteng</div>
                        <div class="text-xs text-gray-500">Super Admin</div>
                    </div>
                    <img src="https://i.pravatar.cc/150?u=admin" class="w-10 h-10 rounded-full border-2 border-gray-200">
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            @yield('content')
        </main>

    </div>

</body>
</html>