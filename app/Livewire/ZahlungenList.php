<?php

namespace App\Livewire;

use App\Models\Zahlung;
use App\Models\Zahlungsart;
use App\Services\FilterService;
use Livewire\Component;
use Livewire\WithPagination;

class ZahlungenList extends Component
{
    use WithPagination;

    public $search = '';
    public $filterZahlungsart = '';
    public $filterTyp = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 10;

    protected $listeners = ['refresh-zahlung-list' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterZahlungsart' => ['except' => ''],
        'filterTyp' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render(FilterService $filterService)
    {
        $query = Zahlung::with('zahlungsart');

        $filters = [
            'search' => $this->search,
            'search_columns' => ['beschreibung', 'rechnungsnr'],
            'dropdowns' => [
                'zahlungsart_id' => $this->filterZahlungsart,
                'typ' => $this->filterTyp,
            ],
            'date_range' => [
                'from' => $this->dateFrom,
                'to' => $this->dateTo,
            ],
            'date_column' => 'datum',
            'sort_by' => 'datum',
            'sort_dir' => 'desc',
        ];

        $query = $filterService->filter($query, $filters);

        // Totals based on filtered query
        $totalEinnahmen = (clone $query)->where('typ', 'Einnahme')->sum('betrag');
        $totalAusgaben = (clone $query)->where('typ', 'Ausgabe')->sum('betrag');
        $bilanz = $totalEinnahmen - $totalAusgaben;

        $items = $query->paginate($this->perPage);
        $zahlungsarten = Zahlungsart::all();

        return view('livewire.zahlungen-list', [
            'items' => $items,
            'zahlungsarten' => $zahlungsarten,
            'totalEinnahmen' => $totalEinnahmen,
            'totalAusgaben' => $totalAusgaben,
            'bilanz' => $bilanz,
        ]);
    }
}
