<?php

namespace App\Livewire;

use App\Models\Mitglied;
use App\Models\Rangart;
use App\Services\FilterService;
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

    public function render(FilterService $filterService)
    {
        $query = Mitglied::with('rangart');

        $filters = [
            'search' => $this->search,
            'search_columns' => ['vorname', 'nachname', 'mitgliedsnummer', 'email'],
            'status' => $this->filterStatus,
            'status_column' => 'austrittsdatum',
            'sort_by' => 'nachname',
            'sort_dir' => 'asc',
        ];

        $members = $filterService->filter($query, $filters)->paginate($this->perPage);
        $rangarten = Rangart::all();

        return view('livewire.members-list', [
            'members' => $members,
            'rangarten' => $rangarten,
        ]);
    }
}
