@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Responsive Styling for the Wedding Section */
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

    <!-- Statistik -->
    <div class="grid grid-cols-3 gap-6 mb-8">
        <!-- Total Undangan -->
        <div class="p-4 bg-primary-dark text-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
            <h2 class="text-lg font-semibold">Total Undangan</h2>
            <p class="text-4xl font-bold">{{ $totalGuests }}</p>
        </div>

        <!-- Tamu Hadir -->
        <div class="p-4 bg-primary-dark text-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
            <h2 class="text-lg font-semibold">Jumlah Hadir</h2>
            <p class="text-4xl font-bold">{{ $totalAttended }}</p>
        </div>

        <!-- Total Tamu -->
        <div class="p-4 bg-primary-dark text-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
            <h2 class="text-lg font-semibold">Jumlah Tamu</h2>
            <p class="text-4xl font-bold">{{ $totalNumberOfGuests }}</p>
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
