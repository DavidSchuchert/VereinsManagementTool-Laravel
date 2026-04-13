<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SettingsManager extends Component
{
    use WithFileUploads;

    public $logo;
    public $appName;
    public $currentLogo;

    public function mount()
    {
        $this->appName = config('app.name');
        $this->currentLogo = Setting::where('key', 'verein_logo')->value('value');
    }

    public function uploadLogo()
    {
        $this->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($this->currentLogo) {
            Storage::disk('public')->delete($this->currentLogo);
        }

        $logoPath = $this->logo->store('logos', 'public');

        Setting::updateOrCreate(
            ['key' => 'verein_logo'],
            ['value' => $logoPath]
        );

        $this->currentLogo = $logoPath;
        $this->logo = null;

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Logo erfolgreich hochgeladen!'
        ]);
    }

    public function updateAppName()
    {
        $this->validate([
            'appName' => 'required|string|max:255',
        ]);

        $envPath = base_path('.env');
        if (File::exists($envPath)) {
            $envContent = File::get($envPath);
            $newEnvContent = preg_replace(
                '/^APP_NAME=.*$/m',
                'APP_NAME="' . $this->appName . '"',
                $envContent
            );
            File::put($envPath, $newEnvContent);
            
            // Clear config cache
            \Artisan::call('config:cache');
        }

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Vereinsname erfolgreich aktualisiert! Bitte Seite neu laden.'
        ]);
    }

    public function render()
    {
        return view('livewire.settings-manager', [
            'errors' => $this->getErrorBag()
        ]);
    }
}
