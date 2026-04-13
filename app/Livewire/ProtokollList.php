<?php

namespace App\Livewire;

use App\Models\Protokoll;
use Livewire\Component;
use Livewire\WithPagination;

class ProtokollList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $listeners = ['refresh-protokoll-list' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $protokoll = Protokoll::findOrFail($id);
        $protokoll->delete();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Protokoll erfolgreich gelöscht.'
        ]);
    }

    public function render()
    {
        $protokolle = Protokoll::with('user')
            ->where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.protokoll-list', [
            'protokolle' => $protokolle,
        ]);
    }
}
