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
        <div class="overflow-x-auto bg-white rounded-lg shadow">
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
                                            <a href="{{ url('/' . $guest->slug) }}" class="block px-4 py-2 text-primary hover:bg-primary-light hover:text-primary-dark">
                                                <i class="fa-solid fa-eye mr-2"></i>Lihat Halaman
                                            </a>
                                        </li>
                                        <li>
                                            <button onclick="openQRModal('{{ route('guests.updateAttendance', ['slug' => $guest->slug]) }}', '{{ $guest->name }}', {{ $guest->number_of_guests ?? 0 }})" class="block w-full text-left px-4 py-2 text-primary hover:bg-primary-light hover:text-primary-dark">
                                                <i class="fa-solid fa-qrcode mr-2"></i>Scan QR
                                            </button>
                                        </li>
                                        <li>
                                            <a href="{{ route('guests.edit', $guest->id) }}" class="block px-4 py-2 text-primary hover:bg-primary-light hover:text-primary-dark">
                                                <i class="fa-solid fa-pen mr-2"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('guests.edit', $guest->id) }}" class="block px-4 py-2 text-primary hover:bg-primary-light hover:text-primary-dark">
                                                <i class="fa-solid fa-camera mr-2"></i>Foto
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/' . $guest->slug) }}" class="block px-4 py-2 text-primary hover:bg-primary-light hover:text-primary-dark">
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

<!-- Modal QR Scanner -->
<div id="qrModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
        <h2 class="text-lg font-bold text-primary-dark mb-4">Scan QR Code</h2>
        
        <!-- Dropdown for camera selection -->
        <div class="mb-4">
            <label for="cameraSelect" class="block text-sm text-gray-600 mb-2">Pilih Kamera:</label>
            <select id="cameraSelect" class="w-full p-2 border rounded" onchange="selectCamera()">
                <option value="">Pilih Kamera</option>
            </select>
        </div>
        
        <div id="qr-reader" class="w-full h-75"></div>
        <button onclick="closeQRModal()" class="absolute top-4 right-4 text-gray-600 hover:text-red-500">
            <i class="fa-solid fa-times text-2xl"></i>
        </button>
    </div>
</div>



<!-- QR Scanner Scripts -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    let html5QrCode;
    let availableDevices = [];
    let currentDeviceId = "";

    function toggleDropdown(button) {
        const dropdown = button.nextElementSibling;
        dropdown.classList.toggle('hidden');
    }

    function openQRModal(updateAttendanceUrl, guestName, numberOfGuests) {
        document.getElementById('qrModal').classList.remove('hidden');

        // Detect available cameras and populate the dropdown
        Html5Qrcode.getCameras().then(devices => {
            availableDevices = devices;
            const cameraSelect = document.getElementById('cameraSelect');
            cameraSelect.innerHTML = '<option value="">Pilih Kamera</option>'; // Clear existing options
            devices.forEach(device => {
                const option = document.createElement('option');
                option.value = device.id;
                option.textContent = device.label || `Kamera ${device.id}`;
                cameraSelect.appendChild(option);
            });

            // Start the QR scanner with the first available device by default
            if (devices.length > 0) {
                currentDeviceId = devices[0].id; // Set default device
                startQRScanner(currentDeviceId); // Start the scanner
            }
        }).catch(err => {
            console.error("Error fetching devices:", err);
        });
    }

    function startQRScanner(deviceId) {
        // Stop the previous QR scanner if it exists
        if (html5QrCode) {
            html5QrCode.stop().catch((err) => {
                console.log("Error stopping QR scanner:", err);
            });
        }

        // Start a new scanner with the selected device
        html5QrCode = new Html5Qrcode("qr-reader");

        html5QrCode.start(
            { deviceId: deviceId },
            { fps: 10, qrbox: { width: 250, height: 250 } },
            (decodedText) => {
                // Handle decoded QR text
                if (decodedText === updateAttendanceUrl) {
                    window.location.href = updateAttendanceUrl;
                } else {
                    closeQRModal();
                    openErrorModal();
                }
            },
            (errorMessage) => {
                console.log("Error scanning:", errorMessage);
            }
        ).catch((err) => {
            console.error("Error initializing scanner:", err);
        });
    }

    function selectCamera() {
        currentDeviceId = document.getElementById('cameraSelect').value;
        if (currentDeviceId) {
            // Start the QR scanner with the selected camera
            startQRScanner(currentDeviceId);
        }
    }

    function closeQRModal() {
        document.getElementById('qrModal').classList.add('hidden');
        if (html5QrCode) {
            html5QrCode.stop().catch(err => {
                console.log("Error stopping QR scanner:", err);
            });
        }
    }

    function openSuccessModal() {
        document.getElementById('successModal').classList.remove('hidden');
    }

    function closeSuccessModal() {
        document.getElementById('successModal').classList.add('hidden');
    }

    function openErrorModal() {
        document.getElementById('errorModal').classList.remove('hidden');
    }

    function closeErrorModal() {
        document.getElementById('errorModal').classList.add('hidden');
    }
</script>

@endsection
