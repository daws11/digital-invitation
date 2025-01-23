@extends('layouts.app')

@section('title', 'Daftar Tamu')
<!-- route data tamu-->
@section('content')
<div class="bg-primary-light min-h-screen py-8 pb-20">
<div class="max-w-sm bg-blue-900 text-white rounded-lg shadow-xl mx-auto mt-20">
    <div class="p-4">
        <div class="flex flex-col items-center text-center space-y-2">
            <div class="text-sm text-gray-300 uppercase tracking-wider">
                The Wedding of
            </div>
            <div class="text-xl font-semibold">
                Jack & Rose
            </div>
            <div class="text-sm text-gray-300">
                Sabtu, 21 September 2024
            </div>
        </div>
    </div>
</div>
    <div class="container mx-auto px-6 pb-20 mt-5">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-xl font-bold text-primary-dark">Data Tamu</h2>
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
            <form id="search-form" class="flex items-center gap-2" method="GET" action="{{ route('showTamu') }}">
                <input type="text" id="search-input" name="search" placeholder="Cari tamu..." class="px-4 py-2 border rounded-lg w-full focus:ring-2 focus:ring-primary outline-none" aria-label="Cari tamu" value="{{ request('search') }}">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition focus:ring-2 focus:ring-primary-light" aria-label="Cari">Cari</button>
            </form>
            </div>
            <table class="min-w-full bg-white relative">
            <thead class="bg-primary-dark text-primary-light">
            <tr>
                <th class="py-3 px-4 border-b text-start">Nama</th>
                <th class="py-3 px-4 border-b w-12">
                <a href="{{ route('guests.create') }}" class="px-4 py-2 bg-primary-white text-bg-primary rounded shadow hover:bg-primary focus:ring-2 focus:ring-primary-light">
                    <i class="fa-solid fa-user-plus"></i>
                </a> 
                </th>
                </tr>
            </thead>
            <tbody>
                @foreach($guests as $guest)
                <tr class="hover:bg-primary-light/50 transition-colors duration-200">
                <td class="py-3 px-4 border-b text-primary-dark">
                    {{ $guest->name }}<br>
                    <span class="text-sm text-gray-500">{{ $guest->phone_number }}</span>
                </td>
                <td class="py-3 px-4 border-b text-center relative">
                    <div class="relative inline-block">
                    <button onclick="toggleDropdown(this, '{{ $guest->slug }}')" class="px-3 py-1 bg-primary text-white rounded shadow hover:bg-primary-dark focus:ring-2 focus:ring-primary-light">
                        <i class="fa-solid fa-cog"></i>
                    </button>
                    </div>
                </td>
                </tr>
                @endforeach
            </tbody>
            </table>
            <div class="m-4">
                {{ $guests->links() }}
            </div>
            <!-- Dropdown Container -->
            <div id="dropdown-container" class="hidden absolute right-0 bg-white border rounded-lg shadow-md mt-2 text-sm z-50 w-48">
            <ul id="dropdown-actions">
                <!-- Actions will be dynamically inserted here -->
            </ul>
            </div>
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

<script>
function toggleDropdown(button, guestSlug) {
    const dropdown = document.getElementById('dropdown-container');
    const rect = button.getBoundingClientRect();
    dropdown.style.top = `${rect.bottom + window.scrollY}px`;
    dropdown.style.left = `${rect.left + window.scrollX}px`;
    dropdown.classList.toggle('hidden');

    const actions = [
        { route: `/${guestSlug}`, icon: 'fa-eye', label: 'Lihat Halaman' },
        { route: `/guests/${guestSlug}/edit`, icon: 'fa-pen', label: 'Edit' },
        { route: `/guests/${guestSlug}`, icon: 'fa-trash', label: 'Hapus', method: 'DELETE' }
    ];

    const dropdownActions = document.getElementById('dropdown-actions');
    dropdownActions.innerHTML = actions.map(action => {
        if (action.method) {
            return `
                <li>
                    <form action="${action.route}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tamu ini?')">
                        @csrf
                        @method('${action.method}')
                        <button type="submit" class="block w-full text-left px-4 py-2 text-danger hover:bg-red-100 hover:text-red-600">
                            <i class="fa-solid ${action.icon} mr-2"></i>${action.label}
                        </button>
                    </form>
                </li>
            `;
        } else {
            return `
                <li>
                    <a href="${action.route}" class="block px-4 py-2 text-primary hover:bg-primary-light hover:text-primary-dark ${action.class || ''}" ${action.data ? `data-guest-slug="${action.data.guestSlug}"` : ''}>
                        <i class="fa-solid ${action.icon} mr-2"></i>${action.label}
                    </a>
                </li>
            `;
        }
    }).join('');
}

document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('dropdown-container');
    if (!dropdown.contains(event.target) && !event.target.closest('button')) {
        dropdown.classList.add('hidden');
    }
});
</script>
@endsection