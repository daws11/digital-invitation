@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
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
                <span class="text-5xl mb-2 text-white hover:text-yellow-300">
                    <i class="fa-solid fa-users"></i>
                </span>
                <span class="text-lg font-bold text-white">Data Tamu</span>
            </a>
        </div>

        
        <div class="bg-primary-dark text-white p-6 rounded-lg shadow-lg flex justify-center items-center transition-shadow duration-300">
            <a href="{{ route('home') }}" 
               class="flex flex-col items-center text-center {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400' }} 
                    hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
                <span class="text-5xl mb-2 text-white hover:text-yellow-300">
                    <i class="fa-solid fa-book"></i>
                </span>
                <span class="text-lg font-bold text-white">Kehadiran</span>
            </a>
        </div>

        
        <div class="bg-primary-dark text-white p-6 rounded-lg shadow-lg flex justify-center items-center transition-shadow duration-300">
            <a href="{{ route('scan-qr.show') }}" 
               class="flex flex-col items-center text-center {{ request()->routeIs('scan-qr.show') ? 'text-white' : 'text-gray-400' }} 
                hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
            <span class="text-5xl mb-2 text-white hover:text-yellow-300">
                <i class="fa-solid fa-qrcode"></i>
            </span>
            <span class="text-lg font-bold text-white">Check In</span>
            </a>
        </div>

        
        <div class="bg-primary-dark text-white p-6 rounded-lg shadow-lg flex justify-center items-center transition-shadow duration-300">
            <a href="{{ route('souvenir.index') }}" 
               class="flex flex-col items-center text-center {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400' }} 
                    hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
                <span class="text-5xl mb-2 text-white hover:text-yellow-300">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </span>
                <span class="text-lg font-bold text-white">Souvenirs</span>
            </a>
        </div>

        
        <div class="bg-primary-dark text-white p-6 rounded-lg shadow-lg flex justify-center items-center transition-shadow duration-300">
            <a href="{{ route('guests.show', ['slug' => 'rsvp']) }}" 
               class="flex flex-col items-center text-center {{ request()->routeIs('guests.show') ? 'text-white' : 'text-gray-400' }} 
                hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
            <span class="text-5xl mb-2 text-white hover:text-yellow-300">
                <i class="fa-solid fa-comments"></i>
            </span>
            <span class="text-lg font-bold text-white">RSVP</span>
            </a>
        </div>

        
        <div class="bg-primary-dark text-white p-6 rounded-lg shadow-lg flex justify-center items-center transition-shadow duration-300">
            <a href="{{ route('guests.show', ['slug' => 'tamu-undangan']) }}" 
               class="flex flex-col items-center text-center {{ request()->routeIs('guests.show') ? 'text-white' : 'text-gray-400' }} 
                    hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
                <span class="text-5xl mb-2 text-white hover:text-yellow-300">
                    <i class="fa-solid fa-desktop"></i>
                </span>
                <span class="text-lg font-bold text-white">Welcome</span>
            </a>
        </div>
    </div>

    <!-- Daftar Tamu -->
    <h2 class="text-2xl font-bold text-primary-dark my-4">Daftar Tamu</h2>
    <div class="overflow-x-auto bg-primary-dark rounded-lg shadow mb-40 ">
        <div class="m-4 text-white text-lg font-semibold">
            Undangan: {{ $totalGuests }} | Hadir: {{ $totalAttended }} ({{ $totalNumberOfGuests }} Orang)
        </div>
        <div class="m-2">
            <form id="search-form" class="flex items-center gap-2">
                <input type="text" id="search-input" placeholder="Cari tamu..." class="px-4 py-2 border rounded-lg w-full focus:ring-2 focus:ring-primary outline-none">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded hover:bg-primary-dark transition">Cari</button>
            </form>
        </div>
        <table id="guests-table" class="min-w-full bg-white border border-gray-200 pb-20">
            <thead>
                <tr class="bg-primary-light border-b text-primary-dark">
                    <th class="py-2 px-4 text-left font-medium">Nama</th>
                    <th class="py-2 px-4 text-left font-medium text-center">Kehadiran</th>
                    <th class="py-2 px-4 text-left font-medium text-center">Jumlah Tamu</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($guests as $guest)
                    <tr class="border-b hover:bg-primary-light/50 transition-colors duration-200">
                        <td class="py-2 px-4 text-primary-dark">{{ $guest->name }}</td>
                        <td class="py-2 px-4 flex justify-center">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $guest->will_attend ? 'bg-primary-light text-primary' : 'bg-gray-100 text-gray-600' }}">
                                {{ $guest->will_attend ? 'Hadir' : 'Tidak' }}
                            </span>
                        </td>
                        <td class="py-2 px-4 text-primary-dark text-center">{{ $guest->number_of_guests ?? '-' }}</td>
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
