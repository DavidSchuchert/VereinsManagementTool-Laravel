<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarController;
use App\Http\Controllers\MitgliederController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\ProtokollController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZahlungController;
use App\Http\Controllers\LogoController;
use App\Http\Middleware\CheckForUpdate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;






Route::middleware(CheckForUpdate::class)->middleware('auth')->group(function () {
    /* Dashboard */
    Route::get("/", [DashboardController::class, 'index'])->name("home");

    /* Setup */
    Route::get('/setup', [LogoController::class, 'index'])->name('setup.index');
    Route::post('/setup/logo-upload', [LogoController::class, 'uploadLogo'])->name('logo.upload');
    Route::post('/setup/update-app-name', [LogoController::class, 'updateAppName'])->name('update.app_name');

    /* Zahlungen */
    Route::resource('/zahlungen', ZahlungController::class);
    Route::get('/pdf/export-zahlungen', [ZahlungController::class, 'exportPdf'])->name('zahlungen.exportPdf');

    /* Mitglieder */
    Route::resource('/mitglieder', MitgliederController::class);
    Route::get('/pdf/export-mitglieder', [MitgliederController::class, 'exportPdf'])->name('mitglieder.exportPdf');

    /* Inventar */
    Route::resource('/inventar', InventarController::class);
    Route::get('/pdf/export-inventar', [InventarController::class, 'exportPdf'])->name('inventar.exportPdf');

    /* User */

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    /* Protokolle */

    Route::get('/protokolle', [ProtokollController::class, 'index'])->name('protokolle.index');
    Route::get('/protokolle/create', [ProtokollController::class, 'create'])->name('protokolle.create');
    Route::post('/protokolle', [ProtokollController::class, 'store'])->name('protokolle.store');
    Route::get('/protokolle/{protokoll}/edit', [ProtokollController::class, 'edit'])->name('protokolle.edit');
    Route::put('/protokolle/{protokoll}', [ProtokollController::class, 'update'])->name('protokolle.update');
    Route::delete('/protokolle/{protokoll}', [ProtokollController::class, 'destroy'])->name('protokolle.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
