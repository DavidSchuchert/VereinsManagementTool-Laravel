<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Akaunting\Apexcharts\Chart;
use App\Models\Zahlung;
use App\Models\Mitglied;
use App\Models\Rangart;

class DashboardController extends Controller
{
    public function index()
    {
        // Einnahmen und Ausgaben berechnen
        $einnahmen = (float) Zahlung::where('typ', 'Einnahme')->sum('betrag');
        $ausgaben = (float) abs(Zahlung::where('typ', 'Ausgabe')->sum('betrag'));

        // Einnahmen vs. Ausgaben Diagramm
        $chart = (new Chart)->setType('donut')
            ->setTitle('Einnahmen vs. Ausgaben')
            ->setSubtitle('Gesamte Transaktionen')
            ->setLabels(['Einnahmen', 'Ausgaben'])
            ->setSeries([$einnahmen, $ausgaben])
            ->setColors(['#28a745', '#dc3545']); // Grün für Einnahmen, Rot für Ausgaben

        // Mitgliederränge abrufen (ohne ausgeschiedene Mitglieder)
        $mitgliederrangCounts = Mitglied::whereNull('austrittsdatum')
            ->selectRaw('rang_id, COUNT(*) as anzahl')
            ->groupBy('rang_id')
            ->pluck('anzahl', 'rang_id');

        $mitgliedergesammt = Mitglied::whereNull('austrittsdatum')->count();

        // Labels und Daten für das Mitgliederränge-Diagramm
        $labels = [];
        $data = [];
        foreach ($mitgliederrangCounts as $rangId => $anzahl) {
            $rangName = Rangart::find($rangId)->name;
            $labels[] = $rangName;
            $data[] = $anzahl;
        }

        // Mitgliederränge-Diagramm erstellen
        $mitgliederChart = (new Chart)->setType('bar')
            ->setTitle('Mitgliederränge')
            ->setSubtitle('Aktive Mitglieder')
            ->setLabels($labels)
            ->setDataset('Mitglieder', 'bar', $data);

        // Beide Diagramme und alle Daten an die View übergeben
        return view('dashboard.index', compact('chart', 'mitgliederChart', 'mitgliedergesammt', 'einnahmen', 'ausgaben'));
    }
}
