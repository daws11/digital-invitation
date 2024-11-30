<!-- Navigation Bar -->
<nav class="fixed bottom-0 left-0 w-full bg-primary-dark border-t shadow-md z-10">
    <div class="container mx-auto flex justify-around py-2 max-w-screen-md">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="text-center flex flex-col items-center {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400' }} hover:text-yellow-300">
            <span><i class="fa-solid fa-chart-line"></i></span>
            <span class="text-xs md:text-sm">Dashboard</span>
        </a>

        <!-- Data Tamu -->
        <a href="{{ route('home') }}" 
           class="text-center flex flex-col items-center {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400' }} hover:text-yellow-300">
            <span><i class="fa-solid fa-users"></i></span>
            <span class="text-xs md:text-sm">Data Tamu</span>
        </a>

        <!-- Scan QR -->
        <div class="text-center flex flex-col items-center">
            <button onclick="openQRModal()" 
                    class="w-16 h-16 bg-orange-400 text-white rounded-full shadow-lg hover:bg-orange-500 flex items-center justify-center focus:outline-none focus:ring-4 focus:ring-orange-300 -mt-8">
                <i class="fa-solid fa-qrcode text-2xl"></i>
            </button>
            <span class="text-xs text-white md:text-sm">Scan QR</span>
        </div>

        <!-- Welcome Page -->
        <a href="{{ route('guests.show', ['slug' => 'tamu-undangan']) }}" 
           class="text-center flex flex-col items-center {{ request()->routeIs('guests.show') ? 'text-white' : 'text-gray-400' }} hover:text-yellow-300">
            <span><i class="fa-solid fa-smile"></i></span>
            <span class="text-xs md:text-sm">Welcome</span>
        </a>

        <!-- Logout -->
        <a href="{{ route('logout') }}" 
           class="text-center flex flex-col items-center text-gray-400 hover:text-yellow-300"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span><i class="fa-solid fa-right-from-bracket"></i></span>
            <span class="text-xs md:text-sm">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</nav>

<!-- QR Scanner Modal -->
<div id="qrModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-md p-6">
        <h2 class="text-2xl font-bold mb-4 text-center">Scan QR Tamu</h2>
        
        <!-- Guest Selection with Search Box and Add Icon beside it -->
        <div class="mb-4">
            <label for="guestDropdown" class="block text-sm font-medium text-gray-700 mb-2">Pilih Tamu</label>
            
            <!-- Custom Dropdown -->
            <div class="relative">
                <!-- Input Search Box -->
                <input type="text" id="guestSearch" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2" placeholder="Cari Tamu" onkeyup="filterGuests()">
                
                <!-- Guest Dropdown -->
                <div class="dropdown-content border border-gray-300 rounded-md max-h-60 overflow-auto">
                    @foreach($guests as $guest)
                        <div class="guest-option py-2 px-3 hover:bg-blue-100 cursor-pointer" data-value="{{ $guest->slug }}">{{ $guest->name }}</div>
                    @endforeach
                </div>
            </div>

            <!-- Add Guest Button -->
            <button class="bg-primary mt-4 text-white px-4 py-2 rounded-md hover:bg-primary-dark transition">
                <a href="{{ route('guests.create') }}"><i class="fa-solid fa-user-plus"></i> Tambah Tamu</a>
            </button>
        </div>

        <!-- Camera Selection Dropdown -->
        <div class="mb-4">
            <label for="cameraSelect" class="block text-sm font-medium text-gray-700 mb-2">Pilih Kamera</label>
            <select id="cameraSelect" onchange="selectCamera()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Pilihh Kamera</option>
            </select>
        </div>

        <!-- QR Scanner Container -->
        <div id="qr-reader" class="w-full h-80 mb-4 border-2 border-dashed border-gray-300"></div>

        <!-- Action Buttons -->
        <div class="flex justify-between">
            <button onclick="handleQRCodeScan()" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                Konfirmasi
            </button>
            <button onclick="closeQRModal()" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                Tutup
            </button>
        </div>
    </div>
</div>
<style>
    .dropdown-content {
        display: none;
        position: absolute;
        width: 100%;
        background-color: white;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }
    
    .dropdown-content .guest-option {
        padding: 10px;
        cursor: pointer;
    }

    .dropdown-content .guest-option:hover {
        background-color: #ddd;
    }

    .dropdown-content.show {
        display: block;
    }

    .dropdown-content .guest-option.selected {
        background-color: #4CAF50;
        color: white;
    }

    nav a, nav button {
        transition: all 0.3s ease;
    }

    nav a:hover span:first-child,
    nav button:hover {
        transform: scale(1.1);
    }

    @media (min-width: 768px) {
        nav a span:first-child {
            font-size: 2rem;
        }
    }
</style>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrCode;
    let availableDevices = [];
    let currentDeviceId = "";
    let selectedGuestSlug = "";

    function openQRModal() {
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
                currentDeviceId = devices[0].id;
                startQRScanner(currentDeviceId);
            }
        }).catch(err => {
            console.error("Error fetching devices:", err);
            alert("Tidak dapat mengakses kamera. Pastikan izin kamera sudah diberikan.");
        });
    }

    function startQRScanner(deviceId) {
        // Stop the previous QR scanner if it exists
        if (html5QrCode) {
            html5QrCode.stop().catch((err) => {
                console.log("Kesalahan menghentikan scanner QR:", err);
            });
        }

        // Get the selected guest slug from dropdown
        selectedGuestSlug = document.getElementById('guestDropdown').value;

        // Start a new scanner with the selected device
        html5QrCode = new Html5Qrcode("qr-reader");

        html5QrCode.start(
            { deviceId: deviceId },
            { fps: 10, qrbox: { width: 250, height: 250 } },
            (decodedText) => {
                // Handle decoded QR text
                if (decodedText === `/guests/${selectedGuestSlug}/update-attendance`) {
                    // Make a fetch request to update attendance when QR code matches
                    fetch(`/guests/${selectedGuestSlug}/update-attendance`, {
                        method: 'GET',
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            openSuccessModal();
                        } else {
                            openErrorModal();
                        }
                    })
                    .catch(err => {
                        console.error('Kesalahan saat memuat:', err);
                        openErrorModal();
                    });
                    closeQRModal();
                } else {
                    closeQRModal();
                    openErrorModal();
                }
            },
            (errorMessage) => {
                console.log("Kesalahan saat memindai:", errorMessage);
            }
        ).catch((err) => {
            console.error("Kesalahan menginisialisasi scanner:", err);
        });
    }

    function selectCamera() {
        currentDeviceId = document.getElementById('cameraSelect').value;
        if (currentDeviceId) {
            startQRScanner(currentDeviceId);
        }
    }

    function handleQRCodeScan() {
        // Optional: Add any additional handling logic before closing the modal
        closeQRModal();
    }

    function closeQRModal() {
        document.getElementById('qrModal').classList.add('hidden');
        if (html5QrCode) {
            html5QrCode.stop().catch(err => {
                console.log("Kesalahan menghentikan scanner QR:", err);
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

    function filterGuests() {
        const input = document.getElementById("guestSearch");
        const filter = input.value.toLowerCase();
        const dropdown = document.querySelector('.dropdown-content');
        const guests = dropdown.querySelectorAll('.guest-option');
        
        // Menampilkan dropdown jika ada input
        dropdown.classList.add("show");

        guests.forEach(function(guest) {
            if (guest.textContent.toLowerCase().includes(filter)) {
                guest.style.display = "block";
            } else {
                guest.style.display = "none";
            }
        });
    }

    // Menutup dropdown jika tidak ada input
    window.onclick = function(event) {
        const dropdown = document.querySelector('.dropdown-content');
        if (!event.target.matches('#guestSearch')) {
            dropdown.classList.remove("show");
        }
    }
</script>
