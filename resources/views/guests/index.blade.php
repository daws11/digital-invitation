@extends('layouts.app')

@section('title', 'Daftar Tamu')

@section('content')
<div class="bg-primary-light min-h-screen py-8 pb-20">
    <!-- Statistik -->
    <div class="grid grid-cols-3 gap-6 mx-8 mb-6">
        @foreach([
            ['title' => 'Total Undangan', 'value' => $totalGuests],
            ['title' => 'Jumlah Hadir', 'value' => $totalAttended],
            ['title' => 'Jumlah Tamu', 'value' => $totalNumberOfGuests],
        ] as $stat)
        <div class="p-4 bg-primary-dark text-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
            <h2 class="text-lg font-semibold">{{ $stat['title'] }}</h2>
            <p class="text-4xl font-bold">{{ $stat['value'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="container mx-auto px-6 pb-20">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-primary-dark">Daftar Tamu</h2>
            <a href="{{ route('guests.create') }}" class="px-4 py-2 bg-primary-dark text-white rounded shadow hover:bg-primary focus:ring-2 focus:ring-primary-light">
                Tambah Tamu
            </a>
        </div>
        <!-- Tombol Ekspor PDF dan Excel -->
        <div class="flex justify-start items-center mb-4">
            <a href="{{ route('guests.exportPDF') }}" class="px-4 py-2 bg-primary-dark text-white rounded shadow hover:bg-primary focus:ring-2 focus:ring-primary-light mr-2">
                Export PDF
            </a>
            <a href="{{ route('guests.exportExcel') }}" class="px-4 py-2 bg-primary-dark text-white rounded shadow hover:bg-primary focus:ring-2 focus:ring-primary-light">
                Export Excel
            </a>
        </div>

        <!-- Tabel Tamu -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-4 bg-primary-dark">
            <form id="search-form" class="flex items-center gap-2 ">
                <input type="text" id="search-input" placeholder="Cari tamu..." class="px-4 py-2 border rounded-lg w-full focus:ring-2 focus:ring-primary outline-none" aria-label="Cari tamu">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition focus:ring-2 focus:ring-primary-light" aria-label="Cari">Cari</button>
            </form>
            </div>
            <table class="min-w-full bg-white">
            <thead class="bg-primary-dark text-primary-light">
                <tr>
                        <th class="py-3 px-4 border-b text-start">Nama</th>
                        <th class="py-3 px-4 border-b text-start">Kehadiran</th>
                        <th class="py-3 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guests as $guest)
                    <tr class="hover:bg-primary-light/50 transition-colors duration-200">
                        <td class="py-3 px-4 border-b text-primary-dark">{{ $guest->name }}</td>
                        <td class="py-3 px-4 border-b">
                            @if ($guest->attended)
                                <span class="text-green-600 font-semibold">Datang</span>
                            @else
                                <span class="text-danger font-semibold">Belum Datang</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 border-b text-center relative">
                            <div class="relative inline-block">
                                <button onclick="toggleDropdown(this)" class="px-3 py-1 bg-primary text-white rounded shadow hover:bg-primary-dark focus:ring-2 focus:ring-primary-light">
                                    Aksi
                                    <i class="fa-solid fa-caret-down ml-2"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        </div>
    </div>
</div>

<!-- Modal Foto -->
<div id="photoModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-4">Foto Tamu</h2>
        <img id="modal-photo" src="" alt="Foto Tamu" class="w-full h-auto mb-4">
        <button id="close-modal-btn" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Tutup</button>
    </div>
</div>

<!-- Dropdown Container -->
<div id="dropdown-container" class="hidden absolute right-0 bg-white border rounded-lg shadow-md mt-2 text-sm z-50 w-48">
    <ul>
        @foreach([
            ['route' => route('guests.show', ['slug' => $guest->slug]), 'icon' => 'fa-eye', 'label' => 'Lihat Halaman'],
            ['route' => route('scan-qr.show'), 'icon' => 'fa-qrcode', 'label' => 'Scan QR'],
            ['route' => route('guests.edit', ['slug' => $guest->slug]), 'icon' => 'fa-pen', 'label' => 'Edit'],
            ['route' => route('photo.index', ['guestSlug' => $guest->slug]), 'icon' => 'fa-camera', 'label' => 'Foto'],
        ] as $action)
        <li>
            <a href="{{ $action['route'] }}" class="block px-4 py-2 text-primary hover:bg-primary-light hover:text-primary-dark">
                <i class="fa-solid {{ $action['icon'] }} mr-2"></i>{{ $action['label'] }}
            </a>
        </li>
        @endforeach
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

<script>
function toggleDropdown(button) {
    const dropdown = document.getElementById('dropdown-container');
    const rect = button.getBoundingClientRect();
    dropdown.style.top = `${rect.bottom + window.scrollY}px`;
    dropdown.style.left = `${rect.left + window.scrollX}px`;
    dropdown.classList.toggle('hidden');
}

document.querySelectorAll('.view-photo-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const guestSlug = e.target.getAttribute('data-guest-slug');
        fetch(`/photo/${guestSlug}/show`)
            .then(response => response.json())
            .then(data => {
                if (data.photo_url) {
                    document.getElementById('modal-photo').src = data.photo_url;
                    document.getElementById('photoModal').classList.remove('hidden');
                } else {
                    alert('Foto tidak ditemukan.');
                }
            })
            .catch(error => alert('Gagal mengambil foto: ' + error.message));
    });
});

document.getElementById('close-modal-btn').addEventListener('click', () => {
    document.getElementById('photoModal').classList.add('hidden');
});
</script>
@endsection