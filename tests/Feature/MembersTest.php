<?php

namespace Tests\Feature;

use App\Models\Mitglied;
use App\Models\Rangart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MembersTest extends TestCase
{
    use RefreshDatabase;

    public function test_members_page_is_rendered()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->get(route('mitglieder.index'))
            ->assertStatus(200)
            ->assertSeeLivewire('members-list')
            ->assertSeeLivewire('members-form');
    }

    public function test_can_create_member()
    {
        $user = User::factory()->create();
        $rang = Rangart::factory()->create();

        Livewire::actingAs($user)
            ->test(\App\Livewire\MembersForm::class)
            ->set('mitgliedsnummer', 'M-12345')
            ->set('vorname', 'Max')
            ->set('nachname', 'Mustermann')
            ->set('email', 'max@example.com')
            ->set('geburtsdatum', '1990-01-01')
            ->set('plz', 12345)
            ->set('ort', 'Musterstadt')
            ->set('strasse', 'Musterstraße')
            ->set('hausnummer', '1')
            ->set('eintrittsdatum', '2023-01-01')
            ->set('rang_id', $rang->id)
            ->call('save')
            ->assertDispatched('refresh-member-list');

        $this->assertDatabaseHas('mitglieder', [
            'mitgliedsnummer' => 'M-12345',
            'vorname' => 'Max',
            'nachname' => 'Mustermann',
        ]);
    }
}
