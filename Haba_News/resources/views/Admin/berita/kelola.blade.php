@extends('Admin.layout')

@section('title', 'Kelola Berita')

@section('content')

{{-- ACTION BAR --}}
<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">

    {{-- Search --}}
    <form action="{{ route('admin.berita') }}" method="GET" class="relative w-full md:w-auto">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm shadow-sm w-full">
        <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
    </form>

    {{-- Action Buttons --}}
    <div class="flex space-x-3">
        {{-- TOMBOL HAPUS SEMUA (BARU) --}}
        <form action="{{ route('admin.berita.deleteAll') }}" method="POST" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus SEMUA berita? Tindakan ini tidak dapat dibatalkan!');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-700 transition shadow-lg flex items-center">
                <i class="fas fa-trash-alt mr-2"></i> Hapus Semua
            </button>
        </form>

        {{-- Add Button (Dummy/Placeholder) --}}
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Berita
        </button>
    </div>

</div>

{{-- TABLE CARD --}}
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
                    <td class="px-6 py-4 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-14 h-14 rounded-lg overflow-hidden flex-shrink-0 mr-4 bg-gray-200 border border-gray-200">
                                <img src="{{ $item->image }}" 
                                     class="w-full h-full object-cover" 
                                     alt="Thumb"
                                     onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=600&auto=format&fit=crop';">
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 line-clamp-1 hover:text-blue-600 cursor-pointer">
                                    {{ $item->title }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <i class="far fa-calendar-alt mr-1"></i> {{ $item->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 font-medium">{{ $item->author }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-gray-100 text-gray-600 py-1 px-3 rounded-full text-xs font-bold border border-gray-200">
                            {{ $item->category }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($item->status == 'published')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                <span class="w-1.5 h-1.5 bg-green-600 rounded-full mr-1.5"></span> Tayang
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                <span class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-1.5"></span> Draft
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2">
                            <form action="{{ route('admin.reject', $item->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini secara permanen?')">
                                @csrf
                                <button class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition" title="Hapus Permanen">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="far fa-folder-open text-4xl mb-3 text-gray-300 block"></i>
                        Belum ada berita.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100">
        {{ $allNews->withQueryString()->links() }}
    </div>
</div>

@endsection