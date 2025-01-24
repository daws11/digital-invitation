<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\ScanQRController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\SouvenirController;
use App\Http\Controllers\SettingsController;
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
    Route::get('/ShowTamu', [GuestController::class, 'showDataTamu'])->name('showTamu');
    Route::get('/guests', [GuestController::class, 'index'])->name('guests.index');
    Route::get('/guests/create', [GuestController::class, 'create'])->name('guests.create');
    Route::post('/guests/import', [GuestController::class, 'import'])->name('guests.import');
    Route::post('/guests', [GuestController::class, 'store'])->name('guests.store');
    Route::get('/guests/{slug}/edit', [GuestController::class, 'edit'])->name('guests.edit');
    Route::put('/guests/{guest}', [GuestController::class, 'update'])->name('guests.update');
    Route::delete('/guests/{slug}', [GuestController::class, 'destroyBySlug'])->name('guests.destroyBySlug');
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
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/checkin', [GuestController::class, 'checkin'])->name('guests.checkin');
    Route::get('/welcome', [GuestController::class, 'welcome'])->name('guests.welcome');
    Route::get('/guests/{slug}/print-qr', [GuestController::class, 'printQr'])->name('guests.printQr');
});

Auth::routes();

Route::get('/{slug?}', [GuestController::class, 'show'])
    ->name('guests.show');
