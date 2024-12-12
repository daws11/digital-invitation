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
        $totalGuests = Guest::count(); 
        $totalAttended = Guest::where('will_attend', 1)->count(); 
        $totalNumberOfGuests = Guest::whereNotNull('number_of_guests')->sum('number_of_guests'); 

        return view('guests.index', compact('totalGuests', 'totalAttended', 'totalNumberOfGuests', 'guests'));
    }

    // Menampilkan form tambah tamu
    public function create()
    {
        return view('guests.create');
    }

    // Menyimpan data tamu
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'greeting_message' => 'nullable|string',
        ]);

        Guest::create([
            'name' => $request->name,
            'greeting_message' => $request->greeting_message,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('home')->with('success', 'Tamu berhasil ditambahkan.');
    }

    // Menampilkan detail tamu berdasarkan slug
    public function show($slug = null)
    {
        $slug = $slug ?? 'tamu-undangan';

        $guest = Guest::where('slug', $slug)->first();

        if (!$guest) {
            $guest = (object) [
                'name' => 'Tamu Undangan',
                'slug' => 'tamu-undangan',
            ];
        }

        $allGreetings = Guest::whereNotNull('greeting_message')->get();

        return view('guests.show', compact('guest', 'allGreetings'));
    }

    // Form untuk mengedit tamu berdasarkan slug
    public function edit($slug)
    {
        // Ambil guest berdasarkan slug
        $guest = Guest::where('slug', $slug)->firstOrFail();
        
        // Tampilkan form edit tamu
        return view('guests.edit', compact('guest'));
    }

    // Memperbarui data tamu
    public function update(Request $request, $slug)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'greeting_message' => 'nullable|string',
        ]);

        // Cari tamu berdasarkan slug
        $guest = Guest::where('slug', $slug)->firstOrFail();

        // Perbarui data tamu
        $guest->update([
            'name' => $request->name,
            'greeting_message' => $request->greeting_message,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('home')->with('success', 'Tamu berhasil diperbarui.');
    }

    // Menghapus tamu berdasarkan ID
    public function destroy($id)
    {
        $guest = Guest::find($id);
        
        if ($guest) {
            $guest->delete();
            return redirect()->route('guests.index')->with('success', 'Tamu berhasil dihapus.');
        }

        return redirect()->route('guests.index')->with('error', 'Tamu tidak ditemukan.');
    }


    // Memperbarui ucapan tamu berdasarkan slug
    public function updateGreeting(Request $request, $slug)
    {
        $request->validate([
            'greeting_message' => 'required|string',
        ]);

        $guest = Guest::where('slug', $slug)->firstOrFail();

        $guest->update([
            'greeting_message' => $request->greeting_message,
        ]);

        return redirect()->route('guests.show', $slug)->with('success', 'Ucapan Anda berhasil dikirim.');
    }

    // Memperbarui RSVP tamu berdasarkan slug
    public function updateRSVP(Request $request, $slug)
    {
        $guest = Guest::where('slug', $slug)->firstOrFail();

        $request->validate([
            'will_attend' => 'required|boolean',
            'number_of_guests' => 'required|integer|min:1|max:5',
        ]);

        $guest->update([
            'will_attend' => $request->will_attend,
            'number_of_guests' => $request->number_of_guests,
        ]);

        return redirect()->route('guests.show', $slug)->with('success', 'RSVP berhasil diperbarui.');
    }
}