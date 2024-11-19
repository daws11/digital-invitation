<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Auth;

// Route default untuk halaman login atau home setelah login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('auth.login');
})->name('default');

Route::put('/guests/{slug}/update-greeting', [GuestController::class, 'updateGreeting'])->name('guests.updateGreeting');

// Route untuk halaman home setelah login
Route::middleware(['auth'])->get('/home', [GuestController::class, 'index'])->name('home');

// Routes untuk autentikasi (login, register, dll.)
Auth::routes();

// Route publik untuk halaman `show` tamu tanpa autentikasi
Route::get('/{slug}', [GuestController::class, 'show'])->name('guests.show');

// Routes untuk fitur CRUD tamu yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Fitur CRUD untuk guests, selain `show`
    Route::resource('guests', GuestController::class)->except(['show'])->names([
        'index' => 'guests.index',
        'create' => 'guests.create',
        'store' => 'guests.store',
        'edit' => 'guests.edit',
        'update' => 'guests.update',
        'destroy' => 'guests.destroy',
    ]);

    // Route untuk update kehadiran tamu melalui QR code, yang juga memerlukan autentikasi
    Route::get('/guests/{slug}/update-attendance', [GuestController::class, 'updateAttendance'])->name('guests.updateAttendance');
});


