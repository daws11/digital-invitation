@extends('layouts.app')

@section('content')
<div class="p-6 bg-primary-light min-h-screen py-20">
    <!-- Header Section -->
    <div class="flex items-center justify-between bg-white shadow-md rounded-lg px-6 py-4 mb-6">
        <h1 class="text-lg font-semibold text-gray-800">Settings</h1>
        <button class="bg-orange-400 text-white px-4 py-2 rounded-lg shadow-md hover:bg-orange-500 transition">
            Akun Saya
        </button>
    </div>

    <!-- Total Events -->
    <div class="bg-blue-600 text-white text-center rounded-lg p-4 mb-6 shadow-md">
        <h2 class="text-lg font-semibold">Total Event: <span class="font-bold">1</span></h2>
    </div>

    <!-- Search Bar -->
    <div class="relative mb-6">
        <input
            type="text"
            placeholder="search event..."
            class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-blue-500 outline-none shadow-sm"
        />
        <button
            class="absolute top-1/2 right-4 transform -translate-y-1/2 text-blue-600 hover:text-blue-800 transition"
        >
            <i class="fas fa-search"></i>
        </button>
    </div>

    <!-- Event Card -->
    <div class=" bg-white shadow-md rounded-lg p-4 flex  gap-4">
        <!-- Event Image -->
        <div class="w-24 h-24 rounded-lg overflow-hidden">
            <img
                src="https://via.placeholder.com/150"
                alt="Event Thumbnail"
                class="w-full h-full object-cover"
            />
        </div>

        <!-- Event Details -->
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-800">Astrid & Fitra</h3>
            <p class="text-gray-600">
                <span class="font-bold">User:</span> Astrid & Fitra
            </p>
            <p class="text-gray-600">
                <span class="font-bold">Tanggal:</span> 21/09/2024
            </p>
            <p class="text-gray-600">
                <span class="font-bold">Undangan:</span> 370
            </p>
            <a
                href="https://undi.co.id/undangan/astrid-and-fitra"
                class="text-blue-600 hover:underline"
            >
                https://undi.co.id/undangan/astrid-and-fitra
            </a>
        </div>

        <!-- Edit Button -->
        <button
            class="flex h-10 items-center bg-orange-400 text-white px-4 py-2 rounded-lg shadow-md hover:bg-orange-500 transition"
        >
            <i class="fas fa-cog"></i>
        </button>
    </div>
</div>
@endsection
