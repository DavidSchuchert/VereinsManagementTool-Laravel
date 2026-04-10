<?php

namespace App\Livewire;

use App\Models\Inventar;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class InventarList extends Component
{
    use WithPagination;

    public $search = '';
    public $filterCategory = '';
    public $perPage = 10;

    protected $listeners = ['refresh-inventar-list' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCategory' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Inventar::with('category');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('artikel', 'like', '%' . $this->search . '%')
                  ->orWhere('ean', 'like', '%' . $this->search . '%')
                  ->orWhere('bemerkung', 'like', '%' . $this->search . '%')
                  ->orWhere('lagerstandort', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->filterCategory)) {
            $query->where('kategorie_id', $this->filterCategory);
        }

        $items = $query->orderBy('created_at', 'desc')->paginate($this->perPage);
        $categories = Category::all();

        return view('livewire.inventar-list', [
            'items' => $items,
            'categories' => $categories,
        ]);
    }
}
