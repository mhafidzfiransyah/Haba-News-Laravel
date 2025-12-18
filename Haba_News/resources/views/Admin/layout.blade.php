<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin HABA NEWS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

            <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.users') ? 'active-nav' : '' }}">
                <i class="fas fa-users w-6"></i>
                <span class="font-medium">Daftar User</span>
            </a>

            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Lainnya</p>

            </a>
            <form method="POST" action="{{ route('logout') }}" class="ml-4">
                @csrf
                <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>
    </aside>

    {{-- MAIN CONTENT WRAPPER --}}
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        {{-- HEADER --}}
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10">
            <div class="flex items-center">
                <button class="md:hidden text-gray-600 mr-4"><i class="fas fa-bars text-xl"></i></button>
                <h2 class="text-xl font-bold text-gray-800">@yield('title')</h2>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden md:block">
                    <div class="text-sm font-bold text-gray-800">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-gray-500">{{ auth()->user()->role }}</div>
                </div>
                <div class="h-10 w-10 rounded-full bg-gray-300 overflow-hidden border-2 border-gray-200">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" alt="Admin" class="h-full w-full object-cover">
                </div>
            </div>
        </header>

        {{-- CONTENT SCROLLABLE --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm" role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            
            @yield('content')
        </main>
    </div>
</body>
</html>