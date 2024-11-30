@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="bg-primary-light min-h-screen p-6">
    <div class="relative w-full mx-auto mb-8">
        <!-- Background Image -->
        <div class="relative">
            <img src="img/jackrose.jpg" alt="Wedding Image" class="w-full h-auto rounded-lg shadow-md">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-gray-900 opacity-50 rounded-lg"></div>
        </div>
    </div>
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-primary-dark">Daftar Tamu Undangan</h1>
        <!-- Tombol untuk menambah tamu baru -->
        <a href="{{ route('guests.create') }}" class="px-4 py-2 bg-primary-dark text-white rounded shadow hover:bg-primary focus:ring-2 focus:ring-primary-light">
            Tambah Tamu
        </a>
    </div>

    <!-- Tabel daftar tamu -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-primary-light border-b">
                    <th class="py-3 px-4 border-r text-left font-medium text-primary-dark">Nama</th>
                    <th class="py-3 px-4 border-r text-left font-medium text-primary-dark">Email</th>
                    <th class="py-3 px-4 border-r text-left font-medium text-primary-dark">Status Kehadiran</th>
                    <th class="py-3 px-4 text-left font-medium text-primary-dark">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guests as $guest)
                    <tr class="border-b hover:bg-primary-light/50 transition-colors duration-200">
                        <td class="py-3 px-4 border-r text-primary-dark">{{ $guest->name }}</td>
                        <td class="py-3 px-4 border-r text-primary-dark">{{ $guest->email }}</td>
                        <td class="py-3 px-4 border-r">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $guest->attended ? 'bg-primary text-white' : 'bg-gray-100 text-gray-600' }}">
                                {{ $guest->attended ? 'Hadir' : 'Belum Hadir' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 flex space-x-2">
                            <a href="{{ route('guests.edit', $guest->id) }}" class="px-3 py-1 text-xs text-white bg-yellow-500 rounded hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-300">Edit</a>
                            <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tamu ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-xs text-white bg-danger rounded hover:bg-danger/90 focus:ring-2 focus:ring-danger/70">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-3 px-4 text-center text-gray-500">Belum ada tamu yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
