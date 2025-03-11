@php
use Illuminate\Support\Facades\Cache;
@endphp
@extends('layouts.guest')
@section('content')
<div class="container mx-auto p-4 bg-primary-light h-screen flex flex-col justify-center items-center" style="background-image: url('/img/carousel-2.jpg'); background-size: cover; background-position: center;">
    <div class="max-w-sm bg-blue-900 text-white rounded-lg shadow-xl mx-auto mt-20">
        <div class="p-4">
            <div class="flex flex-col items-center text-center space-y-2">
                <div class="text-sm text-gray-300 uppercase tracking-wider">
                    Selamat Datang
                </div>
                <div id="guest-name" class="text-xl font-semibold animate-fade-in">
                    @php
                    $lastGuest = Cache::get('last_scanned_guest');
                    $guestType = Cache::get('last_scanned_guest_type');
                    @endphp
                    
                    @if($lastGuest)
                        Yth. Saudara/Saudari {{ $lastGuest }} Beserta Keluarga
                        @if($guestType)
                            <div class="mt-2">
                            @if($guestType == 'VIP')
                                <span class="animate-vip" style="background-color: #D4AF37; color: #000000; padding: 4px 12px; border-radius: 9999px; font-weight: bold; font-size: 0.875rem; display: inline-block; border: 2px solid #FFD700;">{{ $guestType }}</span>
                            @elseif($guestType == 'Special')
                                <span class="px-3 py-1 rounded-full text-sm bg-green-700 text-green-300 font-bold">{{ $guestType }}</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-sm bg-gray-700 text-gray-300 font-bold">{{ $guestType }}</span>
                            @endif
                            </div>
                        @endif
                    @else
                        Seluruh Tamu Undangan Yang Berbahagia
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const guestNameElement = document.getElementById('guest-name');
        const guestTypeElement = document.getElementById('guest-type');
        const cardElement = document.querySelector('.max-w-sm');

        // Function to update guest name with animation
        const updateGuestName = (name) => {
            guestNameElement.classList.remove('animate-fade-in');
            void guestNameElement.offsetWidth; // Trigger reflow to restart animation
            guestNameElement.textContent = name;
            guestNameElement.classList.add('animate-fade-in');
        };

        // Function to update guest type with animation
        const updateGuestType = (type) => {
            guestTypeElement.classList.remove('animate-fade-in', 'vip-text');
            cardElement.classList.remove('vip-card');
            void guestTypeElement.offsetWidth; // Trigger reflow to restart animation
            guestTypeElement.textContent = type;
            guestTypeElement.classList.add('animate-fade-in');
            if (type.toLowerCase() === 'vip') {
                guestTypeElement.classList.add('vip-text');
                cardElement.classList.add('vip-card');
            }
        };

        // Check if guest name and type are already in localStorage
        const guestName = localStorage.getItem('guestName');
        const guestType = localStorage.getItem('guestType');
        if (guestName) {
            updateGuestName(`Yth. Saudara/Saudari ${guestName} Beserta Keluarga`);
        }
        if (guestType) {
            updateGuestType(`Tipe Tamu: ${guestType}`);
        }

        // Listen for storage changes
        window.addEventListener('storage', (event) => {
            if (event.key === 'guestName') {
                updateGuestName(`Yth. Saudara/Saudari ${event.newValue} Beserta Keluarga`);
            }
            if (event.key === 'guestType') {
                updateGuestType(`Tipe Tamu: ${event.newValue}`);
            }
        });

        // Listen for messages from other tabs
        window.addEventListener('message', (event) => {
            if (event.data.type === 'GUEST_UPDATED') {
                updateGuestName(`Yth. Saudara/Saudari ${event.data.guestName} Beserta Keluarga`);
                updateGuestType(`Tipe Tamu: ${event.data.guestType}`);
            }
        });
    });
</script>
<style>
    .animate-fade-in {
        animation: fadeIn 1s ease-in-out;
    }

    .vip-card {
        background-color: gold; /* Warna latar belakang emas */
        color: black; /* Warna teks hitam */
        font-weight: bold;
        border: 2px solid #FFD700; /* Border emas */
    }

    .vip-text {
        color: gold; /* Warna teks emas */
        font-weight: bold;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes vipAnimation {
        from {
            transform: scale(1);
        }
        to {
            transform: scale(1.1);
        }
    }
</style>
@endsection