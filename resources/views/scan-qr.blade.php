@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 bg-primary-light h-screen">
        <h1 class="text-3xl font-bold text-primary-dark text-center mb-6 mt-20">
            Scan QR Code untuk Kehadiran Tamu
        </h1>

        <!-- Dropdown untuk memilih kamera -->
        <div class="mb-4">
            <label for="camera-select" class="block text-lg font-medium mb-2">Pilih Kamera</label>
            <select id="camera-select" class="w-full p-2 border rounded">
                <option value="">Pilih Kamera</option>
            </select>
        </div>

        <!-- QR Code Scanner -->
        <div class="container mx-auto w-full h-max bg-gray-200 rounded-xl">
            <div id="reader" class="w-full h-full bg-gray-200 rounded-xl"></div>
        </div>
    </div>

    <!-- Modal untuk Menampilkan Hasil Kehadiran -->
    <div id="attendance-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-lg mx-4 text-center">
            <h3 class="text-2xl font-semibold mb-4">Kehadiran Tamu Berhasil Diperbarui!</h3>
            <p id="guest-name" class="text-xl mb-2"></p>
            <p id="attendance-status" class="text-lg mb-4"></p>
            <p id="guest-count" class="text-lg"></p>
            <button id="close-modal" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Tutup
            </button>
            <button id="print-qr" class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                Print QR Code
            </button>
        </div>
    </div>

    <!-- Script untuk QR Code Scanner -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let html5QrCode;
        let currentDeviceId = null;
        let videoStream = null;
        let isScannerRunning = false;

        // Menangani pemindaian QR Code
        function onScanSuccess(decodedText, decodedResult) {
            const url = decodedText;
            const regex = /\/guests\/([a-z0-9\-]+)\/update-attendance/;
            const match = url.match(regex);

            if (match) {
                const slug = match[1];

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
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        document.getElementById('guest-name').textContent = `Nama Tamu: ${data.guest.name}`;
                        document.getElementById('attendance-status').textContent = `Kehadiran: ${data.guest.will_attend ? 'Ya' : 'Tidak'}`;
                        document.getElementById('guest-count').textContent = `Jumlah Tamu: ${data.guest.number_of_guests}`;
                        document.getElementById('attendance-modal').classList.remove('hidden');

                        // Store guest name and slug in localStorage
                        localStorage.setItem('guestName', data.guest.name);
                        localStorage.setItem('guestSlug', slug);
                        localStorage.setItem('guestType', data.guest.type); 

                        // Send message to other tabs
                        window.postMessage({ type: 'GUEST_UPDATED', guestName: data.guest.name ,guestType: data.guest.type}, '*');

                        // Set the slug for the print button
                        document.getElementById('print-qr').setAttribute('data-slug', slug);
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
                        if (device.label) {
                            const option = document.createElement('option');
                            option.value = device.deviceId;
                            option.text = device.label;
                            cameraSelect.appendChild(option);
                        }
                    });

                    // Tambahkan event listener untuk perubahan pilihan kamera
                    cameraSelect.addEventListener('change', function() {
                        console.log('Pilihan kamera berubah:', this.value);
                        if (this.value) {
                            currentDeviceId = this.value;
                            startQrCodeScanner();
                        } else {
                            stopQrCodeScanner(); // Matikan pemindaian dan video ketika memilih opsi default
                        }
                    });
                })
                .catch(err => {
                    console.error('Error accessing devices:', err);
                    alert('Terjadi kesalahan saat mengakses perangkat kamera.');
                });
        }

        // Mengambil izin untuk mengakses kamera dan memulai pengambilan daftar kamera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                stream.getTracks().forEach(track => track.stop());
                getCameras();
            })
            .catch(err => {
                console.error('Izin kamera ditolak:', err);
                alert('Mohon izinkan akses ke kamera untuk menggunakan fitur ini.');
            });

        // Memulai pemindaian QR Code dengan kamera yang dipilih
        function startQrCodeScanner() {
            if (isScannerRunning) {
                html5QrCode.stop(); // Stop kamera yang sedang berjalan
            }

            if (!currentDeviceId) {
                alert('Pilih kamera terlebih dahulu!');
                return;
            }

            html5QrCode = new Html5Qrcode("reader");

            html5QrCode.start(
                { deviceId: { exact: currentDeviceId } },  // Menggunakan deviceId kamera yang dipilih
                { fps: 10, qrbox: 200 },  // Mengatur frame per second dan ukuran kotak pemindaian
                onScanSuccess,
                onScanFailure
            ).then((stream) => {
                // Store the media stream for later use
                const videoElement = document.querySelector("#reader video");
                const qrShadedRegion = document.getElementById('qr-shaded-region');
                if (videoElement) {
                    // Memberikan kelas 'rounded-xl' menggunakan Tailwind CSS
                    videoElement.classList.add("rounded-2xl");
                }

                if(qrShadedRegion) {
                    // Memberikan kelas 'rounded-xl' menggunakan Tailwind CSS
                    qrShadedRegion.style.bordercolor = 'transparent'; 
                }
                videoStream = stream;
            })
            .catch((error) => {
                console.error("Error starting QR code scanner:", error);
            });

            isScannerRunning = true; 
        }

        function stopQrCodeScanner() {
            if (isScannerRunning) {
                html5QrCode.stop();  // Stop kamera yang sedang berjalan
            }

            if (videoStream) {
                videoStream.getTracks().forEach(track => track.stop());  // Matikan stream video
            }

            // Setel currentDeviceId ke null untuk menunjukkan bahwa kamera dimatikan
            currentDeviceId = null;
            isScannerRunning = false;
        }

        // Mulai mengambil daftar kamera saat halaman dimuat
        window.onload = function() {
            getCameras();
            console.log('halaman dimuat');
        };

        // Handle print button click
        document.getElementById('print-qr').addEventListener('click', function() {
            const slug = this.getAttribute('data-slug');
            if (slug) {
                window.open(`/guests/${slug}/print-qr`, '_blank');
            } else {
                alert('QR Code tidak valid!');
            }
        });
    </script>
@endsection