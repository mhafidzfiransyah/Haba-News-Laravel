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
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center">Aktivitas</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-500">#{{ $user['id'] }}</td>
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $user['name'] }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $user['email'] }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $user['joined'] }}</td>
                    <td class="px-6 py-4">
                        @if($user['status'] == 'Active')
                            <span class="px-2 py-1 rounded-full bg-green-100 text-green-600 text-xs font-bold">Active</span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold">Banned</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.users.activity', $user['id']) }}" class="text-blue-600 hover:underline text-xs font-bold">Lihat Log</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection