@extends('Admin.layout')

@section('title', 'Kelola Berita')

@section('content')
    
    {{-- ACTION BAR --}}
    <div class="flex justify-between items-center mb-6">
        {{-- Search --}}
        <div class="relative">
            <input type="text" placeholder="Cari berita..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
        </div>

        {{-- Add Button --}}
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Berita
        </button>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
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
                    @foreach($allNews as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-500">{{ $item['id'] }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0 mr-3 bg-gray-200">
                                    <img src="{{ $item['image'] }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800 line-clamp-1">{{ $item['title'] }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $item['date'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $item['author'] }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 text-gray-600 py-1 px-2 rounded text-xs font-medium border border-gray-200">
                                {{ $item['category'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($item['status'] == 'Published')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <span class="w-1.5 h-1.5 bg-green-600 rounded-full mr-1.5"></span>
                                    Tayang
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <span class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-1.5"></span>
                                    Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <button class="w-8 h-8 rounded bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center" title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                                <button class="w-8 h-8 rounded bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center" title="Hapus">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{-- Pagination Dummy --}}
        <div class="px-6 py-4 border-t border-gray-100 flex justify-between items-center">
            <span class="text-xs text-gray-500">Menampilkan 1-10 dari 124 data</span>
            <div class="flex space-x-1">
                <button class="px-3 py-1 rounded border border-gray-300 text-gray-500 text-xs hover:bg-gray-50">Prev</button>
                <button class="px-3 py-1 rounded bg-blue-600 text-white text-xs">1</button>
                <button class="px-3 py-1 rounded border border-gray-300 text-gray-500 text-xs hover:bg-gray-50">2</button>
                <button class="px-3 py-1 rounded border border-gray-300 text-gray-500 text-xs hover:bg-gray-50">Next</button>
            </div>
        </div>
    </div>

@endsection