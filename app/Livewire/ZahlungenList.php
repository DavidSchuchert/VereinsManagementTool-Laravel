<?php

namespace App\Livewire;

use App\Models\Zahlung;
use App\Models\Zahlungsart;
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

    public function render()
    {
        $query = Zahlung::with('zahlungsart');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('beschreibung', 'like', '%' . $this->search . '%')
                  ->orWhere('rechnungsnr', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->filterZahlungsart)) {
            $query->where('zahlungsart_id', $this->filterZahlungsart);
        }

        if (!empty($this->filterTyp)) {
            $query->where('typ', $this->filterTyp);
        }

        if (!empty($this->dateFrom)) {
            $query->where('datum', '>=', $this->dateFrom);
        }

        if (!empty($this->dateTo)) {
            $query->where('datum', '<=', $this->dateTo);
        }

        // Totals based on filtered query
        $totalEinnahmen = (clone $query)->where('typ', 'Einnahme')->sum('betrag');
        $totalAusgaben = (clone $query)->where('typ', 'Ausgabe')->sum('betrag');
        $bilanz = $totalEinnahmen - $totalAusgaben;

        $items = $query->orderBy('datum', 'desc')->paginate($this->perPage);
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
