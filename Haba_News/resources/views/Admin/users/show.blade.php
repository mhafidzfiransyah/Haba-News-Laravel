@extends('Admin.layout')
@section('title', 'Detail User')
@section('content')

<div class="bg-white rounded-xl shadow-sm p-6 max-w-2xl mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4">Detail User</h2>
    
    <p><span class="font-semibold">Nama:</span> {{ $user->name }}</p>
    <p><span class="font-semibold">Email:</span> {{ $user->email }}</p>
    <p><span class="font-semibold">Password (hash):</span> {{ $user->password }}</p>

    <div class="mt-6 flex justify-between">
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
            Kembali
        </a>

        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Hapus
            </button>
        </form>
    </div>
</div>

@endsection
