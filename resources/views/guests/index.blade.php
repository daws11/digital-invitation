<!-- resources/views/guests/index.blade.php -->
@extends('layouts.app')

@section('title', 'Daftar Tamu')

@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-semibold mb-6">Daftar Tamu</h2>
    <a href="{{ route('guests.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        Tambah Tamu
    </a>

    <!-- Kontainer untuk hasil QR scanner -->
    <div id="qr-reader" class="mb-6" style="width: 100%; max-width: 500px;"></div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="py-2 px-4 border-b">Nama</th>
                    <th class="py-2 px-4 border-b">Kehadiran</th>
                    <th class="py-2 px-4 border-b">Link</th>
                    <th class="py-2 px-4 border-b">QR</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guests as $guest)
                    <tr class="text-gray-700">
                        <td class="py-2 px-4 border-b">{{ $guest->name }}</td>
                        <td class="py-2 px-4 border-b">
                            @if ($guest->attended)
                                <span class="text-green-600">Hadir</span>
                            @else
                                <span class="text-red-600">Belum Hadir</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ url('/' . $guest->slug) }}" class="text-blue-500 hover:underline">
                                {{ url('/' . $guest->slug) }}
                            </a>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <button onclick="startQRScanner('{{ route('guests.updateAttendance', $guest->slug) }}')" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Scan QR
                            </button>
                        </td>
                        <td class="py-2 px-4 border-b space-x-2">
                            <a href="{{ route('guests.edit', $guest->id) }}" class="text-yellow-500 hover:underline">Edit</a>
                            <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tamu ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Load Library html5-qrcode -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
function startQRScanner(updateAttendanceUrl) {
    const html5QrCode = new Html5Qrcode("qr-reader");

    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 250, height: 250 } },
        (decodedText) => {
            // Pastikan URL yang dipindai adalah URL updateAttendance
            if (decodedText === updateAttendanceUrl) {
                window.location.href = updateAttendanceUrl;
            } else {
                alert("QR code tidak valid untuk tamu ini.");
            }
            html5QrCode.stop();
        },
        (errorMessage) => {
            console.log("Error scanning:", errorMessage);
        }
    ).catch((err) => {
        console.error("Error initializing scanner:", err);
    });
}
</script>
@endsection
