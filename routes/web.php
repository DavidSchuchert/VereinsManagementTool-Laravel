<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarController;
use App\Http\Controllers\MitgliederController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProtokollController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZahlungController;
use App\Http\Middleware\CheckForUpdate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;



Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', CheckForUpdate::class])
    ->name("dashboard");


Route::middleware(CheckForUpdate::class)->middleware('auth')->group(function () {
    /* Dashboard */
/*     Route::get("/", [DashboardController::class, 'index'])->name("home"); */

    /* Setup / Einstellungen */
    Route::get('/setup', function() {
        return view('setup.index');
    })->name('setup.index');

    /* Zahlungen */
    Route::resource('/zahlungen', ZahlungController::class);
    Route::get('/pdf/export-zahlungen', [ZahlungController::class, 'exportPdf'])->name('zahlungen.exportPdf');

    /* Mitglieder */
    Route::resource('/mitglieder', MitgliederController::class);
    Route::get('/pdf/export-mitglieder', [MitgliederController::class, 'exportPdf'])->name('mitglieder.exportPdf');

    /* Inventar */
    Route::resource('/inventar', InventarController::class);
    Route::get('/pdf/export-inventar', [InventarController::class, 'exportPdf'])->name('inventar.exportPdf');


    /* Dokumente */
    Route::get('/dokumente', function() {
        return view('dokumente.index');
    })->name('dokumente.index');

    /* Import/Export */
    Route::get('/import-export', function() {
        return view('import-export.index');
    })->name('import-export.index');

    /* User */

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    /* Protokolle */

    Route::get('/protokolle', [ProtokollController::class, 'index'])->name('protokolle.index');
    Route::get('/protokolle/{protokoll}/export-pdf', [ProtokollController::class, 'exportSinglePdf'])->name('protokolle.exportSinglePdf');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
