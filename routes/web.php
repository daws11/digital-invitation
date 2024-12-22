<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\ScanQRController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\SouvenirController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : view('auth.login');
})->name('default');

Route::put('/guests/{slug}/update-greeting', [GuestController::class, 'updateGreeting'])
    ->name('guests.updateGreeting');
Route::put('/guests/{slug}/rsvp', [GuestController::class, 'updateRSVP'])->name('guests.updateRSVP');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');    
    Route::get('/api/guests', [HomeController::class, 'getGuests']);
    Route::get('/home', [GuestController::class, 'index'])->name('home');
    Route::get('/guests', [GuestController::class, 'index'])->name('guests.index');
    Route::get('/guests/create', [GuestController::class, 'create'])->name('guests.create');
    Route::post('/guests', [GuestController::class, 'store'])->name('guests.store');
    Route::get('/guests/{slug}/edit', [GuestController::class, 'edit'])->name('guests.edit');
    Route::put('/guests/{guest}', [GuestController::class, 'update'])->name('guests.update');
    Route::delete('/guests/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');
    Route::get('scan-qr', [ScanQRController::class, 'show'])->name('scan-qr.show');
    Route::put('/guests/{slug}/update-attendance', [ScanQRController::class, 'updateAttendance'])->name('guests.updateAttendance');
    Route::post('scan-qr/update-attendance', [ScanQRController::class, 'updateAttendance'])->name('scan-qr.updateAttendance');
    Route::get('/photo/{guestSlug}', [PhotoController::class, 'index'])->name('photo.index');
    Route::post('/photo/store', [PhotoController::class, 'store'])->name('photo.store');
    Route::get('/photo/{guestSlug}/show', [PhotoController::class, 'showPhoto'])->name('photo.show');
    // Rute untuk ekspor PDF
    Route::get('/guests/export/pdf', [GuestController::class, 'exportPDF'])->name('guests.exportPDF');
    // Rute untuk ekspor Excel
    Route::get('/guests/export/excel', [GuestController::class, 'exportExcel'])->name('guests.exportExcel');

    // Route untuk sovenir
    Route::get('guests/souvenir', [SouvenirController::class, 'index'])->name('souvenir.index');
    Route::put('/guests/{slug}/update-souvenir', [SouvenirController::class, 'updateSouvenir'])->name('guests.updateSouvenir');
    Route::get('guests/souvenir/scan-qr', [SouvenirController::class, 'showQR'])->name('souvenir.scan-qr');

});

Auth::routes();

Route::get('/{slug?}', [GuestController::class, 'show'])
    ->name('guests.show');
