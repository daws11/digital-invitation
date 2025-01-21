<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\Log;

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

    public function showDataTamu()
    {
        $guests = Guest::all();
        $totalGuests = Guest::count(); 
        $totalAttended = Guest::where('will_attend', 1)->count(); 
        $totalNumberOfGuests = Guest::whereNotNull('number_of_guests')->sum('number_of_guests'); 

        return view('guests.guest', compact('totalGuests', 'totalAttended', 'totalNumberOfGuests', 'guests'));
    }

    // Menampilkan form tambah tamu
    public function create()
    {
        return view('guests.create');
    }

    // Menyimpan data tamu
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:15',
                'guest_type' => 'nullable|string',
                'custom_guest_type' => 'nullable|string',
            ], [
                'name.required' => 'Nama tamu wajib diisi.',
                'name.string' => 'Nama tamu harus berupa teks.',
                'name.max' => 'Nama tamu tidak boleh lebih dari 255 karakter.',
                
                'phone_number.required' => 'Nomor WA wajib diisi.',
                'phone_number.string' => 'Nomor WA harus berupa teks.',
                'phone_number.max' => 'Nomor WA tidak boleh lebih dari 15 karakter.',
                
                'custom_guest_type.string' => 'Jenis tamu lainnya harus berupa teks.',
            ]);

    
            
            $guestType = !$request->guest_type ? $request->custom_guest_type : $request->guest_type;
            Log::info('Guest type resolved', ['guest_type' => $guestType]);

            if (!$guestType) {
                return redirect()->back()->with('error', 'Jenis tamu lainnya harus diisi');
            }

            Guest::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'guest_type' => $guestType,
                'slug' => Str::slug($request->name),
                'will_attend' => 0,
                'number_of_guests' => 0,
            ]);

            return redirect()->route('home')->with('success', 'Tamu berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Menangkap semua exception dan mengirim pesan error ke session
            return redirect()->back()->with('error', $e->getMessage());
        }
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
            'phone_number' => 'required|string|max:15',
            'guest_type' => 'nullable|string',
            'custom_guest_type' => 'nullable|string',
        ], [
            'name.required' => 'Nama tamu wajib diisi.',
            'name.string' => 'Nama tamu harus berupa teks.',
            'name.max' => 'Nama tamu tidak boleh lebih dari 255 karakter.',
            
            'phone_number.required' => 'Nomor WA wajib diisi.',
            'phone_number.string' => 'Nomor WA harus berupa teks.',
            'phone_number.max' => 'Nomor WA tidak boleh lebih dari 15 karakter.',
            
            
            'custom_guest_type.string' => 'Jenis tamu lainnya harus berupa teks.',
        ]);

        // Cari tamu berdasarkan slug
        $guest = Guest::where('slug', $slug)->firstOrFail();
        $guestType = $request->guest_type === null || $request->guest_type === '' ? $request->custom_guest_type : $request->guest_type;
        // Cek jika tidak ada jenis tamu yang dipilih
        if (!$guestType) {
            return redirect()->back()->with('error', 'Jenis tamu lainnya harus diisi');
        }
    
        // Perbarui data tamu
        $guest->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'guest_type' => $guestType,
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

    public function destroyBySlug($slug)
    {
        $guest = Guest::where('slug', $slug)->firstOrFail();
        
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

    public function exportPDF()
    {
        $guests = Guest::all();
        $pdf = Pdf::loadView('exports.guests-pdf', compact('guests'));
        return $pdf->download('daftar-tamu.pdf');
    }

    // Ekspor Excel
    public function exportExcel()
    {
        $guests = Guest::select('name', 'attended', 'guest_type')->get();

        return Excel::download(new class($guests) implements FromCollection {
            private $guests;

            public function __construct($guests)
            {
                $this->guests = $guests;
            }

            public function collection()
            {
                return $this->guests;
            }
        }, 'daftar-tamu.xlsx');
    }
}