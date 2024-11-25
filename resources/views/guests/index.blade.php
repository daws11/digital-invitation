@extends('layouts.app')

@section('title', 'Daftar Tamu')

@section('content')
<div class="bg-primary-light min-h-screen py-8">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-primary-dark">Daftar Tamu</h2>
            <a href="{{ route('guests.create') }}" class="px-4 py-2 bg-primary-dark text-white rounded shadow hover:bg-primary focus:ring-2 focus:ring-primary-light">
                Tambah Tamu
            </a>
        </div>

        <!-- Kontainer untuk hasil QR scanner -->
        <div id="qr-reader" class="mb-8 bg-white shadow rounded-lg p-4"></div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full bg-white">
                <thead class="bg-primary-light text-primary-dark">
                    <tr>
                        <th class="py-3 px-4 border-b">Nama</th>
                        <th class="py-3 px-4 border-b">Kehadiran</th>
                        <th class="py-3 px-4 border-b">Link</th>
                        <th class="py-3 px-4 border-b">QR</th>
                        <th class="py-3 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guests as $guest)
                        <tr class="hover:bg-primary-light/50 transition-colors duration-200">
                            <td class="py-3 px-4 border-b text-primary-dark">{{ $guest->name }}</td>
                            <td class="py-3 px-4 border-b">
                                @if ($guest->attended)
                                    <span class="text-green-600 font-semibold">Hadir</span>
                                @else
                                    <span class="text-danger font-semibold">Belum Hadir</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 border-b">
                                <a href="{{ url('/' . $guest->slug) }}" class="text-primary hover:underline">
                                    {{ url('/' . $guest->slug) }}
                                </a>
                            </td>
                            <td class="py-3 px-4 border-b">
                                <button onclick="startQRScanner('{{ route('guests.updateAttendance', $guest->slug) }}')" class="px-3 py-1 bg-primary text-white rounded shadow hover:bg-primary-dark focus:ring-2 focus:ring-primary-light">
                                    Scan QR
                                </button>
                            </td>
                            <td class="py-3 px-4 border-b space-x-2">
                                <a href="{{ route('guests.edit', $guest->id) }}" class="text-yellow-500 hover:underline">Edit</a>
                                <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tamu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
