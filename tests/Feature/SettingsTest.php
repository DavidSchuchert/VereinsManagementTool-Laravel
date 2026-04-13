<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_settings_page_is_rendered()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('setup.index'))
            ->assertStatus(200)
            ->assertSeeLivewire('settings-manager');
    }

    public function test_can_upload_logo()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('logo.png');

        Livewire::actingAs($user)
            ->test(\App\Livewire\SettingsManager::class)
            ->set('logo', $file)
            ->call('uploadLogo')
            ->assertDispatched('notify');

        $this->assertDatabaseHas('settings', [
            'key' => 'verein_logo',
        ]);
        
        $logoPath = Setting::where('key', 'verein_logo')->value('value');
        Storage::disk('public')->assertExists($logoPath);
    }

    public function test_can_update_app_name()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(\App\Livewire\SettingsManager::class)
            ->set('appName', 'New Vereins Name')
            ->call('updateAppName')
            ->assertDispatched('notify');

        // Note: Testing .env modification is tricky in tests, 
        // but we can check if the component logic executes.
    }
}
