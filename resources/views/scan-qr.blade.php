@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 bg-primary-light">
        <h1 class="text-3xl font-bold text-primary-dark text-center mb-6">Scan QR Code untuk Kehadiran Tamu</h1>

        <!-- Dropdown untuk memilih kamera -->
        <div class="mb-4">
            <label for="camera-select" class="block text-lg font-medium mb-2">Pilih Kamera</label>
            <select id="camera-select" class="w-full p-2 border rounded">
                <option value="">Pilih Kamera</option>
            </select>
        </div>

        <!-- QR Code Scanner -->
        <div id="reader" class="w-full h-96 bg-gray-200 rounded-lg mb-6"></div>
    </div>

    <!-- Modal untuk Menampilkan Hasil Kehadiran -->
    <div id="attendance-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-xl w-1/3 text-center">
            <h3 class="text-2xl font-semibold mb-4">Kehadiran Tamu Berhasil Diperbarui!</h3>
            <p id="guest-name" class="text-xl mb-2"></p>
            <p id="attendance-status" class="text-lg mb-4"></p>
            <p id="guest-count" class="text-lg"></p>
            <button id="close-modal" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Tutup</button>
        </div>
    </div>

    <!-- Script untuk QR Code Scanner -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let html5QrCode;
        let currentDeviceId = null;

        // Menangani pemindaian QR Code
        function onScanSuccess(decodedText, decodedResult) {
            // Ambil slug dari URL yang dipindai
            const url = decodedText;
            const regex = /\/guests\/([a-z0-9\-]+)\/update-attendance/;
            const match = url.match(regex);

            if (match) {
                const slug = match[1];  // Ambil slug dari URL yang dipindai

                // Menggunakan fetch untuk melakukan request PUT ke server
                fetch(`/guests/${slug}/update-attendance`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        attended: true
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal memperbarui kehadiran. Status: ' + response.status);
                    }
                    return response.json();  // Jika berhasil, konversi ke JSON
                })
                .then(data => {
                    if (data.success) {
                        // Tampilkan modal dengan informasi tamu
                        document.getElementById('guest-name').textContent = `Nama Tamu: ${data.guest.name}`;
                        document.getElementById('attendance-status').textContent = `Kehadiran: ${data.guest.attended ? 'Ya' : 'Tidak'}`;
                        document.getElementById('guest-count').textContent = `Jumlah Tamu: ${data.guest.number_of_guests}`;

                        // Tampilkan modal
                        document.getElementById('attendance-modal').classList.remove('hidden');
                    } else {
                        alert('Tamu tidak ditemukan!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan: ' + error.message);
                });
            } else {
                alert('QR Code tidak valid!');
            }
        }

        function onScanFailure(error) {
            console.warn(`QR scan error: ${error}`);
        }

        // Menutup modal
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('attendance-modal').classList.add('hidden');
        });

        // Mengambil daftar kamera yang tersedia
        function getCameras() {
            navigator.mediaDevices.enumerateDevices()
                .then(devices => {
                    const cameras = devices.filter(device => device.kind === 'videoinput');
                    const cameraSelect = document.getElementById('camera-select');

                    // Kosongkan dropdown sebelum mengisi
                    cameraSelect.innerHTML = '<option value="">Pilih Kamera</option>';

                    // Masukkan kamera yang ditemukan ke dropdown
                    cameras.forEach(device => {
                        const option = document.createElement('option');
                        option.value = device.deviceId;
                        option.text = device.label || `Kamera ${cameraSelect.length + 1}`;
                        cameraSelect.appendChild(option);
                    });

                    // Tambahkan event listener untuk perubahan pilihan kamera
                    cameraSelect.addEventListener('change', function() {
                        if (this.value) {
                            currentDeviceId = this.value;
                            startQrCodeScanner();
                        }
                    });
                })
                .catch(err => {
                    console.error('Error accessing devices:', err);
                    alert('Terjadi kesalahan saat mengakses perangkat kamera.');
                });
        }

        // Memulai pemindaian QR Code dengan kamera yang dipilih
        function startQrCodeScanner() {
            if (html5QrCode) {
                html5QrCode.stop(); // Stop kamera yang sedang berjalan
            }

            if (!currentDeviceId) {
                alert('Pilih kamera terlebih dahulu!');
                return;
            }

            html5QrCode = new Html5Qrcode("reader");

            html5QrCode.start(
                { deviceId: { exact: currentDeviceId } },  // Menggunakan deviceId kamera yang dipilih
                { fps: 10, qrbox: 250 },  // Mengatur frame per second dan ukuran kotak pemindaian
                onScanSuccess,
                onScanFailure
            );
        }

        // Mulai mengambil daftar kamera saat halaman dimuat
        window.onload = function() {
            getCameras();
        };
    </script>
@endsection
