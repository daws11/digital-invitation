<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Daftar Tamu Undangan</h1>
            <!-- Tombol untuk menambah tamu baru -->
            <a href="{{ route('guests.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Tambah Tamu
            </a>
        </div>

        <!-- Tabel daftar tamu -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="py-2 px-4 border-r text-left text-gray-700 font-medium">Nama</th>
                        <th class="py-2 px-4 border-r text-left text-gray-700 font-medium">Email</th>
                        <th class="py-2 px-4 border-r text-left text-gray-700 font-medium">Status Kehadiran</th>
                        <th class="py-2 px-4 text-left text-gray-700 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guests as $guest)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4 border-r">{{ $guest->name }}</td>
                            <td class="py-2 px-4 border-r">{{ $guest->email }}</td>
                            <td class="py-2 px-4 border-r">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $guest->attended ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $guest->attended ? 'Hadir' : 'Belum Hadir' }}
                                </span>
                            </td>
                            <td class="py-2 px-4 flex space-x-2">
                                <a href="{{ route('guests.edit', $guest->id) }}" class="px-3 py-1 text-xs text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tamu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-xs text-white bg-red-500 rounded hover:bg-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-2 px-4 text-center text-gray-500">Belum ada tamu yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
