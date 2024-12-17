@extends('layouts.app')

@section('title', 'Daftar Tamu')

@section('content')
<div class="bg-primary-light min-h-screen py-8">
    
<!-- Statistik -->
<div class="grid grid-cols-3 gap-6 mx-8 mb-6">
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
        
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-primary-dark">Daftar Tamu</h2>
            <a href="{{ route('guests.create') }}" class="px-4 py-2 bg-primary-dark text-white rounded shadow hover:bg-primary focus:ring-2 focus:ring-primary-light">
                Tambah Tamu
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow">
    <table class="min-w-full bg-white">
        <thead class="bg-primary-light text-primary-dark">
            <tr>
                <th class="py-3 px-4 border-b">Nama</th>
                <th class="py-3 px-4 border-b">Kehadiran</th>
                <th class="py-3 px-4 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guests as $guest)
                <tr class="hover:bg-primary-light/50 transition-colors duration-200">
                    <!-- Nama -->
                    <td class="py-3 px-4 border-b text-primary-dark">{{ $guest->name }}</td>
                    
                    <!-- Kehadiran -->
                    <td class="py-3 px-4 border-b">
                        @if ($guest->attended)
                            <span class="text-green-600 font-semibold">Datang</span>
                        @else
                            <span class="text-danger font-semibold">Belum Datang</span>
                        @endif
                    </td>
                    
                    <!-- Dropdown Aksi -->
<td class="py-3 px-4 border-b text-center relative">
    <div class="relative inline-block">
        <button onclick="toggleDropdown(this)" class="px-3 py-1 bg-primary text-white rounded shadow hover:bg-primary-dark focus:ring-2 focus:ring-primary-light">
            Aksi
            <i class="fa-solid fa-caret-down ml-2"></i>
        </button>
        <ul class="hidden absolute right-0 bg-white border rounded-lg shadow-md mt-2 text-sm z-50">
            <li>
                <a href="{{ route('guests.show', ['slug' => $guest->slug]) }}" class="block px-4 py-2 text-primary hover:bg-primary-light hover:text-primary-dark">
                    <i class="fa-solid fa-eye mr-2"></i>Lihat Halaman
                </a>
            </li>
            <li>
                <a href="{{ route('scan-qr.show') }}" class="block w-full text-left px-4 py-2 text-primary hover:bg-primary-light hover:text-primary-dark">
                    <i class="fa-solid fa-qrcode mr-2"></i>Scan QR
                </a>
            </li>
            <li>
            <a href="{{ route('guests.edit', ['slug' => $guest->slug]) }}" class="block px-4 py-2 text-primary hover:bg-primary-light hover:text-primary-dark">
                <i class="fa-solid fa-pen mr-2"></i>Edit
            </a>
            </li>
            <li>
                <a href="{{ route('photo.index', ['guestSlug' => $guest->slug]) }}" class="block px-4 py-2 text-primary hover:bg-primary-light hover:text-primary-dark">
                    <i class="fa-solid fa-camera mr-2"></i>Foto
                </a>
            </li>
            <li>
                <a href="#" class="block px-4 py-2 text-primary hover:bg-primary-light hover:text-primary-dark view-photo-btn" data-guest-slug="{{ $guest->slug }}">
                    <i class="fa-solid fa-film mr-2"></i>Lihat Foto
                    </a>
            </li>
            <li>
                <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tamu ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="block w-full text-left px-4 py-2 text-danger hover:bg-red-100 hover:text-red-600">
                        <i class="fa-solid fa-trash mr-2"></i>Hapus
                    </button>
                </form>
            </li>
        </ul>
    </div>
</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

        </div>
    </div>
</div>
</div>
</div>

<!-- Modal untuk Menampilkan Foto -->
<div id="photoModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-4">Foto Tamu</h2>
        <img id="modal-photo" src="" alt="Foto Tamu" class="w-full h-auto mb-4">
        <button id="close-modal-btn" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Tutup</button>
    </div>
</div>

<script>
    function toggleDropdown(button) {
        const dropdown = button.nextElementSibling;
        dropdown.classList.toggle('hidden');
    }

   // Menambahkan event listener untuk semua tombol "Lihat Foto"
   document.querySelectorAll('.view-photo-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const guestSlug = e.target.getAttribute('data-guest-slug');
        
        // Ambil foto tamu dari server
        fetch(`/photo/${guestSlug}/show`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal mengambil foto, status: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.photo_url) {
                    document.getElementById('modal-photo').src = data.photo_url;
                    document.getElementById('photoModal').classList.remove('hidden');
                } else {
                    alert('Foto tidak ditemukan.');
                }
            })
            .catch(error => {
                console.error('Terjadi kesalahan saat mengambil foto:', error);
                alert('Gagal mengambil foto: ' + error.message);
            });
    });
});

    // Menutup modal
    document.getElementById('close-modal-btn').addEventListener('click', function() {
        document.getElementById('photoModal').classList.add('hidden');
    });
</script>

@endsection
