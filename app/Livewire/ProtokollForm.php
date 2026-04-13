<?php

namespace App\Livewire;

use App\Models\Protokoll;
use App\Events\NewProtokoll;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProtokollForm extends Component
{
    public $showModal = false;
    public $protokollId = null;

    public $title;
    public $content;

    protected $listeners = ['open-protokoll-form' => 'open'];

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ];

    public function open($id = null)
    {
        $this->resetValidation();
        
        if ($id) {
            $this->protokollId = $id;
            $protokoll = Protokoll::findOrFail($id);
            $this->title = $protokoll->title;
            $this->content = $protokoll->content;
        } else {
            $this->reset(['title', 'content', 'protokollId']);
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->protokollId) {
            $protokoll = Protokoll::find($this->protokollId);
            $protokoll->update([
                'title' => $this->title,
                'content' => $this->content,
            ]);
        } else {
            $protokoll = Protokoll::create([
                'title' => $this->title,
                'content' => $this->content,
                'user_id' => Auth::id(),
            ]);
            
            broadcast(new NewProtokoll($protokoll))->toOthers();
        }

        $this->showModal = false;
        $this->dispatch('refresh-protokoll-list');
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $this->protokollId ? 'Protokoll erfolgreich aktualisiert.' : 'Protokoll erfolgreich erstellt.'
        ]);
    }

    public function render()
    {
        return view('livewire.protokoll-form');
    }
}
