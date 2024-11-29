<?php

namespace App\Http\Controllers;

use App\Models\Inventar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InventarController extends Controller
{

    private function applyFilters(Request $request)
    {
        $query = Inventar::query();

        if ($request->filled('suche')) {
            $query->where(function ($q) use ($request) {
                $q->where('artikel', 'like', '%' . $request->suche . '%')
                    ->orWhere('bemerkung', 'like', '%' . $request->suche . '%');
            });
        }

        if ($request->filled('hinzugefuegt_von')) {
            $query->where('created_at', '>=', $request->hinzugefuegt_von);
        }
        if ($request->filled('hinzugefuegt_bis')) {
            $query->where('created_at', '<=', $request->hinzugefuegt_bis);
        }

        if ($request->filled('ean')) {
            $query->where('ean', 'like', '%' . $request->ean . '%');
        }

        if ($request->filled('lagerstandort')) {
            $query->where('lagerstandort', 'like', '%' . $request->lagerstandort . '%');
        }

        if ($request->filled('menge_von')) {
            $query->where('menge', '>=', $request->menge_von);
        }
        if ($request->filled('menge_bis')) {
            $query->where('menge', '<=', $request->menge_bis);
        }

        if ($request->filled('kategorie_id')) {
            $query->where('kategorie_id', $request->kategorie_id);
        }

        return $query;
    }

    /* PDF EXPORT! */

    public function exportPdf(Request $request)
    {
        // Filter für Zahlungen anwenden
        $query = $this->applyFilters($request);

        $inventar = $query->orderBy('lagerstandort', 'desc')->get();
        $pdf = Pdf::loadView('pdf.inventar', compact('inventar'));

        return $pdf->download('inventar_' . date('Y-m-d_H-i-s') . '.pdf');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inventar::query();

        $query = $this->applyFilters($request);

        $inventar = $query->orderBy("created_at", "desc")->paginate(15);

        return view("inventar.index", compact("inventar"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validierung der Eingaben
        $request->validate([
            'artikel' => 'required|string|max:255',
            'ean' => 'required|string|max:50',
            'menge' => 'required|integer|min:1',
            'lagerstandort' => 'required|string|max:100',
            'bemerkung' => 'required|string|max:500',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Erstellen eines neuen Inventar-Objekts
        $inventar = new Inventar();
        $inventar->artikel = $request->input('artikel');
        $inventar->ean = $request->input('ean');
        $inventar->menge = $request->input('menge');
        $inventar->lagerstandort = $request->input('lagerstandort');
        $inventar->bemerkung = $request->input('bemerkung');

        // Speichern des Inventarartikels in der Datenbank
        $inventar->save();

        // Umleitung zurück zur Übersicht mit einer Erfolgsmeldung
        return redirect()->route('inventar.index')->with('success', 'Artikel erfolgreich hinzugefügt!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validierung der Eingaben
        $request->validate([
            'artikel' => 'required|string|max:255',
            'ean' => 'required|string|max:50',
            'menge' => 'required|integer|min:1',
            'lagerstandort' => 'required|string|max:100',
            'bemerkung' => 'required|string|max:500',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $inventar = Inventar::findOrFail($id);

        // Erstellen eines neuen Inventar-Objekts
        $inventar->artikel = $request->input('artikel');
        $inventar->ean = $request->input('ean');
        $inventar->menge = $request->input('menge');
        $inventar->lagerstandort = $request->input('lagerstandort');
        $inventar->bemerkung = $request->input('bemerkung');

        // Speichern des Inventarartikels in der Datenbank
        $inventar->save();

        // Umleitung zurück zur Übersicht mit einer Erfolgsmeldung
        return redirect()->route('inventar.index')->with('success', 'Artikel erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $artikel = Inventar::findOrFail($id);
        $artikel->delete();
        return redirect('/inventar')->with('success', 'Artikel erfolgreich gelöscht!');
    }
}
