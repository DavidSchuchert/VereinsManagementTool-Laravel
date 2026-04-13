<?php

namespace Tests\Feature;

use App\Models\Protokoll;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProtokollTest extends TestCase
{
    use RefreshDatabase;

    public function test_protokoll_list_is_rendered()
    {
        $user = User::factory()->create();
        Protokoll::factory()->count(3)->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('protokolle.index'))
            ->assertStatus(200)
            ->assertSeeLivewire('protokoll-list')
            ->assertSeeLivewire('protokoll-form');
    }

    public function test_can_create_protokoll()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(\App\Livewire\ProtokollForm::class)
            ->set('title', 'Test Protokoll')
            ->set('content', 'Dies ist ein Testinhalt.')
            ->call('save')
            ->assertDispatched('refresh-protokoll-list')
            ->assertDispatched('notify', function($name, $params) {
                return $params['type'] === 'success';
            });

        $this->assertDatabaseHas('protokolle', [
            'title' => 'Test Protokoll',
            'content' => 'Dies ist ein Testinhalt.',
            'user_id' => $user->id,
        ]);
    }

    public function test_can_edit_protokoll()
    {
        $user = User::factory()->create();
        $protokoll = Protokoll::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(\App\Livewire\ProtokollForm::class)
            ->call('open', $protokoll->id)
            ->set('title', 'Updated Title')
            ->call('save')
            ->assertDispatched('refresh-protokoll-list');

        $this->assertDatabaseHas('protokolle', [
            'id' => $protokoll->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_can_delete_protokoll()
    {
        $user = User::factory()->create();
        $protokoll = Protokoll::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(\App\Livewire\ProtokollList::class)
            ->call('delete', $protokoll->id)
            ->assertDispatched('notify');

        $this->assertSoftDeleted('protokolle', [
            'id' => $protokoll->id,
        ]);
    }
}
