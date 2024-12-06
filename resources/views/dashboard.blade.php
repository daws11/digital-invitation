@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Custom styles for the Wedding Section (if necessary) */
    .wedding-image {
        position: relative;
    }

    .wedding-image img {
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .wedding-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.7));
        border-radius: 10px;
    }

    .wedding-text {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
    }

    .wedding-text h1 {
        font-size: 2rem;
        font-weight: bold;
    }

    .wedding-text p {
        margin-top: 0.5rem;
    }
</style>

<div class="bg-primary-light min-h-screen p-6">
    <div class="relative w-full mx-auto mb-8">
        <!-- Background Image -->
        <div class="relative">
            <img src="img/jackrose.jpg" alt="Wedding Image" class="w-full h-auto rounded-lg shadow-md">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-gray-900 opacity-50 rounded-lg"></div>
        </div>
    </div>

    <!-- Menu Cards -->
    <div class="grid grid-cols-2 gap-6">
        <!-- Card 1: Data Tamu -->
        <div class="bg-primary-dark text-white p-6 rounded-lg shadow-lg flex justify-center items-center transition-shadow duration-300">
            <a href="{{ route('home') }}" 
               class="flex flex-col items-center text-center {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400' }} 
                    hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
                <span class="text-5xl mb-2">
                    <i class="fa-solid fa-users"></i>
                </span>
                <span class="text-lg">Data Tamu</span>
            </a>
        </div>

        <!-- Card 2: Buku Tamu -->
        <div class="bg-primary-dark text-white p-6 rounded-lg shadow-lg flex justify-center items-center transition-shadow duration-300">
            <a href="{{ route('home') }}" 
               class="flex flex-col items-center text-center {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400' }} 
                    hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
                <span class="text-5xl mb-2">
                    <i class="fa-solid fa-book"></i>
                </span>
                <span class="text-lg">Kehadiran</span>
            </a>
        </div>

        <!-- Card 3: Laporan -->
        <div class="bg-primary-dark text-white p-6 rounded-lg shadow-lg flex justify-center items-center transition-shadow duration-300">
            <a href="{{ route('home') }}" 
               class="flex flex-col items-center text-center {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400' }} 
                    hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
                <span class="text-5xl mb-2">
                    <i class="fa-solid fa-qrcode"></i>
                </span>
                <span class="text-lg">Check In</span>
            </a>
        </div>

        <!-- Card 4: Jadwal -->
        <div class="bg-primary-dark text-white p-6 rounded-lg shadow-lg flex justify-center items-center transition-shadow duration-300">
            <a href="{{ route('home') }}" 
               class="flex flex-col items-center text-center {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400' }} 
                    hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
                <span class="text-5xl mb-2">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </span>
                <span class="text-lg">Souvenirs</span>
            </a>
        </div>

        <!-- Card 5: Pengaturan -->
        <div class="bg-primary-dark text-white p-6 rounded-lg shadow-lg flex justify-center items-center transition-shadow duration-300">
            <a href="{{ route('home') }}" 
               class="flex flex-col items-center text-center {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400' }} 
                    hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
                <span class="text-5xl mb-2">
                    <i class="fa-solid fa-comments"></i>
                </span>
                <span class="text-lg">RSVP</span>
            </a>
        </div>

        <!-- Card 6: Logout -->
        <div class="bg-primary-dark text-white p-6 rounded-lg shadow-lg flex justify-center items-center transition-shadow duration-300">
            <a href="{{ route('guests.show', ['slug' => 'tamu-undangan']) }}" 
               class="flex flex-col items-center text-center {{ request()->routeIs('guests.show') ? 'text-white' : 'text-gray-400' }} 
                    hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
                <span class="text-5xl mb-2">
                    <i class="fa-solid fa-desktop"></i>
                </span>
                <span class="text-lg">Welcome</span>
            </a>
        </div>
    </div>

    <!-- Daftar Tamu -->
    <h2 class="text-2xl font-bold text-primary-dark mb-4">Daftar Tamu</h2>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-primary-light border-b text-primary-dark">
                    <th class="py-2 px-4 text-left font-medium">Nama</th>
                    <th class="py-2 px-4 text-left font-medium">Kehadiran</th>
                    <th class="py-2 px-4 text-left font-medium">Jumlah Tamu</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($guests as $guest)
                    <tr class="border-b hover:bg-primary-light/50 transition-colors duration-200">
                        <td class="py-2 px-4 text-primary-dark">{{ $guest->name }}</td>
                        <td class="py-2 px-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $guest->will_attend ? 'bg-primary-light text-primary' : 'bg-gray-100 text-gray-600' }}">
                                {{ $guest->will_attend ? 'Hadir' : 'Tidak' }}
                            </span>
                        </td>
                        <td class="py-2 px-4 text-primary-dark">{{ $guest->number_of_guests ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-2 px-4 text-center text-gray-500">Belum ada tamu yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
