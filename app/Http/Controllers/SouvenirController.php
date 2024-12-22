<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class SouvenirController extends Controller
{
    public function index()
    {
        // Contoh data tamu untuk ditampilkan
        $guests = Guest::select('name', 'souvenir_received')
        ->where('souvenir_received', true)
        ->paginate(10); // Tampilkan 10 tamu per halaman

        $totalSouvenirs = $guests->total(); // Hitung total tamu yang menerima souvenir

        return view('souvenir.index', compact('guests', 'totalSouvenirs'));
    }

    function showQR()
    {
        return view('souvenir.scan-qr');
    }
    public function updateSouvenir($slug)
    {
        try {
            // Cari tamu berdasarkan id
            $guest = Guest::where('slug', $slug)->firstOrFail();

            // Validasi data souvenir yang dikirimkan
            $guest->souvenir_received = true;
            $guest->save();
           
            // Kirim data tamu dalam response
            return response()->json([
                'success' => true,
                'guest' => [
                    'name' => $guest->name,
                    'souvenir_received' => $guest->souvenir_received,
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            // Tangani kesalahan jika tamu tidak ditemukan
            return response()->json(['success' => false, 'message' => 'Tamu tidak ditemukan'], 404);
        } catch (\Exception $e) {
            // Tangani kesalahan umum
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan.'], 500);
        }
    }

}
