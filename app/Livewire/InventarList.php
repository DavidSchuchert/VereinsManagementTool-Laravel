<?php

namespace App\Livewire;

use App\Models\Inventar;
use App\Models\Category;
use App\Services\FilterService;
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

    public function render(FilterService $filterService)
    {
        $query = Inventar::with('category');

        $filters = [
            'search' => $this->search,
            'search_columns' => ['artikel', 'ean', 'bemerkung', 'lagerstandort'],
            'dropdowns' => [
                'kategorie_id' => $this->filterCategory,
            ],
            'sort_by' => 'created_at',
            'sort_dir' => 'desc',
        ];

        $items = $filterService->filter($query, $filters)->paginate($this->perPage);
        $categories = Category::all();

        return view('livewire.inventar-list', [
            'items' => $items,
            'categories' => $categories,
        ]);
    }
}
