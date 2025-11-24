@extends('Admin.layout')
@section('title', 'Daftar Pengguna')
@section('content')

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-gray-800">User Terdaftar</h3>
        <div class="relative">
            <input type="text" placeholder="Cari user..." class="pl-8 pr-4 py-1.5 border border-gray-300 rounded text-sm focus:outline-none focus:border-blue-500">
            <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400 text-xs"></i>
        </div>
    </div>
    
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
            <tr>
                <th class="px-6 py-3">ID</th>
                <th class="px-6 py-3">Nama User</th>
                <th class="px-6 py-3">Email</th>
                <th class="px-6 py-3">Bergabung</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-sm divide-y divide-gray-100">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50">
                <!-- mengubah id agar terurut di tabel website -->
                <td class="px-6 py-4 text-gray-500">#{{ $loop->iteration }}</td> 
                <td class="px-6 py-4 font-bold text-gray-800">{{ $user->name }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:underline text-xs font-bold">
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-6 text-center text-gray-500">Belum ada user.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">
        {{ $users->links() }}
    </div>
</div>

@endsection