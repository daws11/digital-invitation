@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-primary-light min-h-screen p-6">
    <div class="relative w-full mx-auto mb-8 py-20">
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

        <!-- Card: Trigger Modal for Check-in -->
        <div class="bg-primary-dark text-white p-6 rounded-lg shadow-lg flex justify-center items-center transition-shadow duration-300">
            <button id="triggerModal" class="flex flex-col items-center text-center hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
                <span class="text-5xl mb-2 text-white hover:text-yellow-300">
                    <i class="fa-solid fa-qrcode"></i>
                </span>
                <span class="text-lg font-bold text-white">Check-in</span>
            </button>
        </div>

        <div class="bg-primary-dark text-white p-6 rounded-lg shadow-lg flex justify-center items-center transition-shadow duration-300">
            <a href="{{ route('souvenir.index') }}" 
               class="flex flex-col items-center text-center {{ request()->routeIs('souvenir.index') ? 'text-white' : 'text-gray-400' }} 
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
    <div class="overflow-x-auto bg-primary-dark rounded-lg shadow mb-40">
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

    <!-- Modal Pop-up -->
    <div id="checkInModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full">
            <!-- Header -->
            <div class="bg-primary text-white text-center p-4 rounded-t-lg">
                <h3 class="text-xl font-bold">Check-in Tamu</h3>
            </div>
            <!-- Body -->
            <div class="p-6 text-center">
                <p class="text-gray-700 mb-6">Pilih salah satu cara check-in:</p>
                <!-- Buttons -->
                <div class="space-y-4">
                    <a href="{{ route('scan-qr.show') }}" 
                        class="flex items-center justify-center text-center bg-green-500  text-white  px-4 py-2 rounded hover:bg-green-600 transition
                            hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
                            <i class="fa-solid fa-qrcode mr-2"></i> Scan QR-Code
                    </a>
                    <button id="triggerSearchModal" class="w-full items-center justify-center text-center bg-green-500  text-white  px-4 py-2 rounded hover:bg-green-600 transition
                        hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
                        <i class="fa-solid fa-search mr-2"></i> Cari Tamu Terdaftar
                    </button>
                    <a href="{{ route('guests.create') }}" class="flex items-center justify-center text-center bg-green-500  text-white  px-4 py-2 rounded hover:bg-green-600 transition
                        hover:text-yellow-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-transform duration-200">
                        <i class="fa-solid fa-user-plus mr-2"></i> Input Tamu Baru
                    </a>
                    <button id="closeModalBtn" class="w-full flex items-center justify-center bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 transition">
                        <i class="fa-solid fa-times mr-2"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Cari Tamu Terdaftar -->
    <div id="searchModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full">
            <!-- Header -->
            <div class="bg-primary text-white text-center p-4 rounded-t-lg">
                <h3 class="text-xl font-bold">Cari Tamu Terdaftar</h3>
            </div>
            <!-- Body -->
            <div class="p-6">
                <form id="search-form-modal" class="flex items-center gap-2">
                    <input type="text" id="search-input-modal" placeholder="Cari tamu..." class="px-4 py-2 border rounded-lg w-full focus:ring-2 focus:ring-primary outline-none">
                </form>
                <div class="m-2 mt-4">
                    <table id="search-results" class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-primary-light border-b text-primary-dark">
                                <th class="py-2 px-4 text-left font-medium">Nama</th>
                            </tr>
                        </thead>
                        <tbody id="search-results-body">
                            <!-- Search results will be displayed here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Footer -->
            <button id="closeSearchModal" class="w-full flex items-center justify-center bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 transition">
                <i class="fa-solid fa-times mr-2"></i> Tutup
            </button>
        </div>
    </div>

</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Get elements
        const checkInModal = document.getElementById('checkInModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const triggerModal = document.getElementById('triggerModal');
        const searchModal = document.getElementById('searchModal');
        const closeSearchModalBtn = document.getElementById('closeSearchModal');
        const triggerSearchModal = document.getElementById('triggerSearchModal');


         // Open search modal
        triggerSearchModal.addEventListener('click', () => {
            searchModal.classList.remove('hidden');
            checkInModal.classList.add('hidden');

        });

        // Close search modal
        closeSearchModalBtn.addEventListener('click', () => {
            searchModal.classList.add('hidden');
        });


        // Open modal
        triggerModal.addEventListener('click', () => {
            checkInModal.classList.remove('hidden');
        });

        // Close modal
        closeModalBtn.addEventListener('click', () => {
            checkInModal.classList.add('hidden');
        });

        // Close modal on outside click
        checkInModal.addEventListener('click', (e) => {
            if (e.target === checkInModal) {
                checkInModal.classList.add('hidden');
            }
        });
    });
</script>
