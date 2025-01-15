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

    <!-- Event Card -->
    <div class="bg-white shadow-md rounded-lg p-4 flex gap-4 relative">
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

        <!-- Edit Button with Dropdown -->
        <div class="relative">
            <button
                id="edit-dropdown-toggle"
                class="flex h-10 items-center bg-orange-400 text-white px-4 py-2 rounded-lg shadow-md hover:bg-orange-500 transition"
            >
                <i class="fas fa-cog"></i>
            </button>
            <div
                id="edit-dropdown-menu"
                class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md hidden z-10"
            >
                <a
                    href="#"
                    id="open-edit-modal"
                    class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-100 transition"
                >
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a
                    href="#"
                    class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-100 transition"
                >
                    <i class="fas fa-envelope mr-2"></i> Template WA
                </a>
                <a
                    href="#"
                    class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-100 transition"
                >
                    <i class="fas fa-tv mr-2"></i> Layar Sapa
                </a>
            </div>
        </div>
    </div>
</div>


<!-- Edit Modal -->
<div
    id="edit-modal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50"
>
    <div class="bg-white rounded-lg w-96 p-6 relative shadow-lg">
        <!-- Header -->
        <h2 class="text-lg font-bold mb-4 text-gray-800">Edit Event</h2>

        <!-- Form -->
        <form>
            <!-- Event -->
            <div class="mb-4">
                <label for="event" class="block text-sm font-medium text-gray-700">Event</label>
                <input
                    type="text"
                    id="event"
                    placeholder="Ex: The Wedding of"
                    class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-blue-500 outline-none"
                />
            </div>

            <!-- Name Event -->
            <div class="mb-4">
                <label for="name-event" class="block text-sm font-medium text-gray-700">Name Event</label>
                <input
                    type="text"
                    id="name-event"
                    placeholder="Ex: Romeo & Juliet"
                    class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-blue-500 outline-none"
                />
            </div>

            <!-- Tanggal Event -->
            <div class="mb-6">
                <label for="date-event" class="block text-sm font-medium text-gray-700">Tanggal Event</label>
                <input
                    type="date"
                    id="date-event"
                    class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-blue-500 outline-none"
                />
            </div>

            <!-- Buttons -->
            <button
                type="submit"
                class="bg-blue-500 text-white w-full py-2 rounded-lg shadow-md hover:bg-blue-600 transition"
            >
                Update
            </button>
            <div class="my-4 flex justify-end w-full ">
                <button
                    type="button"
                    id="close-modal"
                    class="bg-gray-400 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-500 transition"
                    >
                    Close
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById("edit-dropdown-toggle");
        const menu = document.getElementById("edit-dropdown-menu");

        toggle.addEventListener("click", function () {
            menu.classList.toggle("hidden");
        });

        document.addEventListener("click", function (e) {
            if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add("hidden");
            }
        });

        const modal = document.getElementById("edit-modal");
        const openModalButton = document.getElementById("open-edit-modal");
        const closeModalButton = document.getElementById("close-modal");

        openModalButton.addEventListener("click", function (e) {
            e.preventDefault();
            modal.classList.remove("hidden");
        });

        closeModalButton.addEventListener("click", function () {
            modal.classList.add("hidden");
        });

        document.addEventListener("click", function (e) {
            if (!modal.contains(e.target) && !e.target.closest("#open-edit-modal")) {
                modal.classList.add("hidden");
            }
        });
    });
</script>
@endsection
