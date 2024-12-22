@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 bg-primary-light h-screen">
        <h1 class="text-3xl font-bold text-primary-dark text-center mb-6">
            Scan QR Code untuk menerima souvenir
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
    <div id="souvenir-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-xl w-1/3 text-center">
            <h3 class="text-2xl font-semibold mb-4">Pengambilan Souvenir Berhasil!</h3>
            <p id="guest-name" class="text-xl mb-2"></p>
            <p id="souvenir-taken" class="text-lg"></p>
            <button id="close-modal" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Tutup
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
                const slug = match[1];  // Ambil slug dari URL yang dipindai

                // Menggunakan fetch untuk melakukan request PUT ke server
                fetch(`/guests/${slug}/update-souvenir`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
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
                        document.getElementById('souvenir-taken').textContent = `Souvenir diambil`;

                        // Tampilkan modal
                        document.getElementById('souvenir-modal').classList.remove('hidden');
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
            document.getElementById('souvenir-modal').classList.add('hidden');
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
                { fps: 10, qrbox: 500 },  // Mengatur frame per second dan ukuran kotak pemindaian
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
    </script>
@endsection
