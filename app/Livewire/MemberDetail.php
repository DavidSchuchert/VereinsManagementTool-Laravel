<?php

namespace App\Livewire;

use App\Models\Mitglied;
use Livewire\Component;

class MemberDetail extends Component
{
    public $showModal = false;
    public $member = null;

    protected $listeners = ['show-member-details' => 'show'];

    public function show($id)
    {
        $this->member = Mitglied::with('rangart')->findOrFail($id);
        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
        $this->member = null;
    }

    public function render()
    {
        return view('livewire.member-detail');
    }
}
