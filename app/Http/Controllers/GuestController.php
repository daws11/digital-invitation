<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    // Menampilkan daftar tamu
    public function index()
    {
        $guests = Guest::all();
        return view('guests.index', compact('guests'));
    }

    // Menampilkan form untuk menambah tamu baru
    public function create()
    {
        return view('guests.create');
    }

    // Menyimpan tamu baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'greeting_message' => 'nullable|string',
        ]);

        Guest::create([
            'name' => $request->name,
            'greeting_message' => $request->greeting_message,
            'slug' => Str::slug($request->name) // Generate slug dari nama
        ]);

        // Pastikan untuk mengarahkan ke 'home' atau 'guests.index' yang tersedia
        return redirect()->route('home')->with('success', 'Tamu berhasil ditambahkan.');
    }

    // Menampilkan detail tamu berdasarkan slug tanpa mengubah status kehadiran
    public function show($slug)
    {
        // Temukan tamu berdasarkan slug untuk menampilkan detail spesifik mereka
        $guest = Guest::where('slug', $slug)->firstOrFail();

        // Ambil semua ucapan yang ada dari seluruh tamu
        $allGreetings = Guest::whereNotNull('greeting_message')->get();

        return view('guests.show', compact('guest', 'allGreetings'));
}

    // Menampilkan form edit tamu
    public function edit(Guest $guest)
    {
        return view('guests.edit', compact('guest'));
    }

    // Memperbarui data tamu
    public function update(Request $request, Guest $guest)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'greeting_message' => 'nullable|string',
        ]);

        $guest->update([
            'name' => $request->name,
            'greeting_message' => $request->greeting_message,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('home')->with('success', 'Tamu berhasil diperbarui.');
    }

    // Menghapus tamu dari database
    public function destroy(Guest $guest)
    {
        $guest->delete();
        return redirect()->route('home')->with('success', 'Tamu berhasil dihapus.');
    }

    // Memperbarui status kehadiran tamu setelah QR code dipindai
    public function updateAttendance($slug)
    {
        $guest = Guest::where('slug', $slug)->firstOrFail();

        if (!$guest->attended) {
            $guest->update(['attended' => true]);
        }

        return redirect()->route('home')->with('success', 'Kehadiran tamu berhasil diperbarui.');
    }

    public function updateGreeting(Request $request, $slug)
{
    $request->validate([
        'greeting_message' => 'required|string'
    ]);

    $guest = Guest::where('slug', $slug)->firstOrFail();

    // Perbarui kolom 'greeting_message' dengan ucapan yang diberikan
    $guest->update([
        'greeting_message' => $request->greeting_message,
    ]);

    return redirect()->route('guests.show', $slug)->with('success', 'Ucapan Anda berhasil dikirim.');
}

}
