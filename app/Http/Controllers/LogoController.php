<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Setting;

class LogoController extends Controller
{
    public function index()
    {
        return view('setup.index'); // Entferne das Leerzeichen im View-Namen
    }

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Speichere das Logo in public/logos
        $logoPath = $request->file('logo')->store('logos', 'public');

        // Speichere den Pfad in der Datenbank
        Setting::updateOrCreate(
            ['key' => 'verein_logo'],
            ['value' => $logoPath]
        );

        return back()->with('success', 'Logo erfolgreich hochgeladen!');
    }

    public function updateAppName(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
        ]);

        // Hole den aktuellen Inhalt der .env-Datei
        $envPath = base_path('.env');
        $envContent = File::get($envPath);

        // Aktualisiere den APP_NAME-Wert in der .env-Datei
        $newEnvContent = preg_replace(
            '/^APP_NAME=.*$/m',
            'APP_NAME="' . $request->app_name . '"',
            $envContent
        );

        File::put($envPath, $newEnvContent);

        // Leere den Cache, damit die Änderungen übernommen werden
        \Artisan::call('config:cache');

        return back()->with('success', 'Vereinsname erfolgreich aktualisiert! Bitte Seite neu laden.');
    }
}
