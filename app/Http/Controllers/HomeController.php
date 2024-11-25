<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the dashboard after login.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $totalGuests = Guest::count(); // Jumlah undangan
        $totalAttended = Guest::where('will_attend', 1)->count(); // Jumlah tamu yang hadir
        $totalNumberOfGuests = Guest::whereNotNull('number_of_guests')->sum('number_of_guests'); // Total tamu yang hadir

        $guests = Guest::select('name', 'will_attend', 'number_of_guests')->get(); // Daftar tamu

        return view('dashboard', compact('totalGuests', 'totalAttended', 'totalNumberOfGuests', 'guests'));
    }

}
