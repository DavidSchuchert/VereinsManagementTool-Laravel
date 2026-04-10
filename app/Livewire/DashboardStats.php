<?php

namespace App\Livewire;

use App\Models\Mitglied;
use App\Models\Zahlung;
use App\Models\Inventar;
use App\Models\Protokoll;
use App\Models\Rangart;
use Livewire\Component;

class DashboardStats extends Component
{
    public function render()
    {
        // 1. Members Stats
        $totalMembers = Mitglied::count();
        $activeMembers = Mitglied::whereNull('austrittsdatum')->count();
        $inactiveMembers = Mitglied::whereNotNull('austrittsdatum')->count();

        // 2. Latest Items
        $latestProtocols = Protokoll::orderBy('created_at', 'desc')->take(5)->get();
        $latestInventory = Inventar::with('category')->orderBy('created_at', 'desc')->take(5)->get();

        // 3. Financials
        $totalIncome = Zahlung::where('typ', 'Einnahme')->sum('betrag');
        $totalExpense = Zahlung::where('typ', 'Ausgabe')->sum('betrag');

        // 4. Data for ApexCharts (Member Ranks)
        $memberRanks = Mitglied::whereNull('austrittsdatum')
            ->selectRaw('rang_id, COUNT(*) as count')
            ->groupBy('rang_id')
            ->get()
            ->map(function($item) {
                return [
                    'name' => Rangart::find($item->rang_id)->name ?? 'Unbekannt',
                    'count' => $item->count
                ];
            });

        return view('livewire.dashboard-stats', [
            'totalMembers' => $totalMembers,
            'activeMembers' => $activeMembers,
            'inactiveMembers' => $inactiveMembers,
            'latestProtocols' => $latestProtocols,
            'latestInventory' => $latestInventory,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'memberRankLabels' => $memberRanks->pluck('name'),
            'memberRankData' => $memberRanks->pluck('count'),
        ]);
    }
}
