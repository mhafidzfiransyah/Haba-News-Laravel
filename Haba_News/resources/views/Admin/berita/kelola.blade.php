@extends('Admin.layout')

@section('title', 'Kelola Berita')

@section('content')
    
    {{-- ACTION BAR (Search & Tambah) --}}
    <div class="flex justify-between items-center mb-6">
        {{-- Search Input --}}
        <div class="relative">
            <input type="text" placeholder="Cari berita..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm shadow-sm">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
        </div>

        {{-- Tombol Tambah --}}
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Berita
        </button>
    </div>

    {{-- TABLE CONTAINER --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-700 text-xs uppercase font-bold">
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Berita</th>
                        <th class="px-6 py-4">Penulis</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($allNews as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-500 font-medium">{{ $item['id'] }}</td>
                        
                        {{-- Kolom Berita (Gambar + Judul) --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-14 h-14 rounded-lg overflow-hidden flex-shrink-0 mr-4 bg-gray-200 border border-gray-200">
                                    {{-- Gambar Full Cover (No Letterbox) --}}
                                    <img src="{{ $item['image'] }}" class="w-full h-full object-cover" alt="Thumbnail" onerror="this.src='https://via.placeholder.com/150'">
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800 line-clamp-1 hover:text-blue-600 cursor-pointer" title="{{ $item['title'] }}">
                                        {{ $item['title'] }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1 flex items-center">
                                        <i class="far fa-calendar-alt mr-1"></i> {{ $item['date'] }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Kolom Penulis --}}
                        <td class="px-6 py-4 text-gray-600 font-medium">
                            <div class="flex items-center">
                                <i class="far fa-user-circle mr-2 text-gray-400"></i>
                                {{ $item['author'] }}
                            </div>
                        </td>

                        {{-- Kolom Kategori --}}
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 text-gray-600 py-1 px-3 rounded-full text-xs font-bold border border-gray-200">
                                {{ $item['category'] }}
                            </span>
                        </td>

                        {{-- Kolom Status --}}
                        <td class="px-6 py-4">
                            @if($item['status'] == 'Published')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                    <span class="w-1.5 h-1.5 bg-green-600 rounded-full mr-1.5"></span>
                                    Tayang
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                    <span class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-1.5"></span>
                                    Draft
                                </span>
                            @endif
                        </td>

                        {{-- Kolom Opsi --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <button class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 flex items-center justify-center transition" title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                                <button class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 flex items-center justify-center transition" title="Hapus">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="far fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                <p>Belum ada berita yang ditambahkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- PAGINATION (DUMMY TAMPILAN) --}}
        <div class="px-6 py-4 border-t border-gray-100 flex justify-between items-center bg-gray-50">
            <span class="text-xs text-gray-500 font-medium">Menampilkan 1-10 dari 124 data</span>
            <div class="flex space-x-1">
                <button class="px-3 py-1 rounded border border-gray-300 text-gray-500 text-xs hover:bg-white hover:text-blue-600 transition bg-white shadow-sm">Prev</button>
                <button class="px-3 py-1 rounded bg-blue-600 text-white text-xs font-bold shadow-md">1</button>
                <button class="px-3 py-1 rounded border border-gray-300 text-gray-500 text-xs hover:bg-white hover:text-blue-600 transition bg-white shadow-sm">2</button>
                <button class="px-3 py-1 rounded border border-gray-300 text-gray-500 text-xs hover:bg-white hover:text-blue-600 transition bg-white shadow-sm">Next</button>
            </div>
        </div>
    </div>

@endsection