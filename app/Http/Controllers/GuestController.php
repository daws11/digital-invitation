<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    public function index()
    {
        $guests = Guest::all(); // Ambil semua tamu
        $totalGuests = Guest::count(); 
        $totalAttended = Guest::where('will_attend', 1)->count(); 
        $totalNumberOfGuests = Guest::whereNotNull('number_of_guests')->sum('number_of_guests'); 
        $guests = Guest::select('name', 'will_attend', 'number_of_guests')->get(); 
        
        return view('guests.index', compact('totalGuests', 'totalAttended', 'totalNumberOfGuests', 'guests'));
    }

    public function create()
    {
        return view('guests.create');
    }


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

    public function edit(Guest $guest)
    {
        return view('guests.edit', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'greeting_message' => 'nullable|string',
        ]);

        $guest->update([
            'name' => $request->name,
            'greeting_message' => $request->greeting_message,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('home')->with('success', 'Tamu berhasil diperbarui.');
    }

    public function destroy(Guest $guest)
    {
        $guest->delete();
        return redirect()->route('home')->with('success', 'Tamu berhasil dihapus.');
    }

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
            'greeting_message' => 'required|string',
        ]);

        $guest = Guest::where('slug', $slug)->firstOrFail();

        $guest->update([
            'greeting_message' => $request->greeting_message,
        ]);

        return redirect()->route('guests.show', $slug)->with('success', 'Ucapan Anda berhasil dikirim.');
    }

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
    public function handleDynamicQRScan(Request $request)
    {
        try {
            // Validate slug from the request
            $request->validate([
                'slug' => 'required|string|exists:guests,slug',
            ]);
    
            // Retrieve the guest record
            $guest = Guest::where('slug', $request->slug)->firstOrFail();
    
            // Check if the guest has not marked attendance yet
            if (!$guest->attended) {
                $guest->update(['attended' => true]);
            }
    
            // Respond with success
            return response()->json([
                'success' => true,
                'message' => 'Attendance updated successfully.',
                'guest' => [
                    'name' => $guest->name,
                    'number_of_guests' => $guest->number_of_guests,
                ],
            ]);
        } catch (\Exception $e) {
            // Handle any error that occurs
            return response()->json([
                'success' => false,
                'message' => 'Failed to update attendance.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

