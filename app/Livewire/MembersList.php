<?php

namespace App\Livewire;

use App\Models\Mitglied;
use App\Models\Rangart;
use Livewire\Component;
use Livewire\WithPagination;

class MembersList extends Component
{
    use WithPagination;

    protected $listeners = ['refresh-member-list' => '$refresh'];

    public $search = '';
    public $filterStatus = 'all';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Mitglied::with('rangart');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('vorname', 'like', '%' . $this->search . '%')
                  ->orWhere('nachname', 'like', '%' . $this->search . '%')
                  ->orWhere('mitgliedsnummer', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus === 'active') {
            $query->whereNull('austrittsdatum');
        } elseif ($this->filterStatus === 'inactive') {
            $query->whereNotNull('austrittsdatum');
        }

        $members = $query->paginate($this->perPage);
        $rangarten = Rangart::all();

        return view('livewire.members-list', [
            'members' => $members,
            'rangarten' => $rangarten,
        ]);
    }
}
