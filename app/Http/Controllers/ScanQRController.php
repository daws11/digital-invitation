<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;

class ScanQRController extends Controller
{
    public function show()
    {
        // Ambil data tamu untuk dropdown
        $guests = Guest::all();
        return view('scan-qr', compact('guests'));
    }

    public function updateAttendance($slug)
{
    try {
        // Cari tamu berdasarkan slug
        $guest = Guest::where('slug', $slug)->firstOrFail();

        // Update status kehadiran
        $guest->attended = true;
        $guest->save();

        // Kirim data tamu dalam response
        return response()->json([
            'success' => true,
            'guest' => [
                'name' => $guest->name,
                'will_attend' => $guest->will_attend,
                'number_of_guests' => $guest->number_of_guests
            ]
        ]);
    } catch (\Exception $e) {
        // Tangani kesalahan jika tamu tidak ditemukan
        return response()->json(['success' => false, 'message' => 'Tamu tidak ditemukan'], 404);
    }
}

}

