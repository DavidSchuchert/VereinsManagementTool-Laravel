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
    public $filterLocation = '';
    public $perPage = 10;

    protected $listeners = ['refresh-inventar-list' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterLocation' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render(FilterService $filterService)
    {
        $query = Inventar::with(['category', 'location']);

        $filters = [
            'search' => $this->search,
            'search_columns' => ['artikel', 'ean', 'bemerkung', 'lagerstandort'],
            'dropdowns' => [
                'kategorie_id' => $this->filterCategory,
                'location_id' => $this->filterLocation,
            ],
            'sort_by' => 'created_at',
            'sort_dir' => 'desc',
        ];

        $filteredQuery = $filterService->filter($query, $filters);
        
        $totalItems = (clone $filteredQuery)->count();
        $totalQuantity = (clone $filteredQuery)->sum('menge');
        $totalCategories = Category::count();

        $items = $filteredQuery->paginate($this->perPage);
        $categories = Category::where('type', 'inventar')->get();
        $locations = Category::where('type', 'location')->get();

        return view('livewire.inventar-list', [
            'items' => $items,
            'categories' => $categories,
            'locations' => $locations,
            'totalItems' => $totalItems,
            'totalQuantity' => $totalQuantity,
            'totalCategories' => $totalCategories,
        ]);
    }
}
