<?php

namespace App\Http\Controllers;

use App\Models\Zahlung;
use App\Models\Zahlungsart;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Storage;

class ZahlungController extends Controller
{

    /* FILTERUNG */

    private function applyFilters(Request $request)
    {
        $query = Zahlung::query();

        if ($request->filled('suche')) {
            $query->where(function ($q) use ($request) {
                $q->where('beschreibung', 'like', '%' . $request->suche . '%');
            });
        }

        if ($request->filled('datum_von')) {
            $query->where('datum', '>=', $request->datum_von);
        }
        if ($request->filled('datum_bis')) {
            $query->where('datum', '<=', $request->datum_bis);
        }

        if ($request->filled('zahlungsart_id')) {
            $query->where('zahlungsart_id', $request->zahlungsart_id);
        }

        if ($request->filled('betrag_von')) {
            $query->where('betrag', '>=', $request->betrag_von);
        }
        if ($request->filled('betrag_bis')) {
            $query->where('betrag', '<=', $request->betrag_bis);
        }

        if ($request->filled('rechnungsnummer')) {
            $query->where('rechnungsnr', 'like', '%' . $request->rechnungsnummer . '%');
        }

        return $query;
    }

    /* PDF EXPORT! */
    public function exportPdf(Request $request)
    {
        // Filter für Zahlungen anwenden
        $query = $this->applyFilters($request);

        $zahlungen = $query->orderBy('datum', 'desc')->get();
        $pdf = Pdf::loadView('pdf.zahlungen', compact('zahlungen'));

        return $pdf->download('zahlungen_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Zahlung::query();
        $meldung = null;

        // Filter für Zahlungen anwenden
        $query = $this->applyFilters($request);

        $zahlungen = $query->orderBy('created_at', 'desc')->paginate(15);

        $summe = Zahlung::sum('betrag');

        $zahlungsarten = Zahlungsart::orderBy('id')->pluck('name', 'id');

        return view('zahlungen.index', compact('zahlungen', 'summe', 'zahlungsarten', 'meldung'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validierung der Eingaben
        $request->validate([
            'beschreibung' => 'required|string|max:255',
            'rechnungsnr' => 'nullable|string|max:50',
            'datum' => 'required|date',
            'betrag' => 'required|numeric',
            'zahlungsart_id' => 'required|exists:zahlungsarten,id',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Erstellen eines neuen Zahlung-Objekts
        $zahlung = new Zahlung();
        $zahlung->beschreibung = $request->input('beschreibung');
        $zahlung->rechnungsnr = $request->input('rechnungsnr');
        $zahlung->datum = $request->input('datum');
        $zahlung->betrag = $request->input('betrag');
        $zahlung->zahlungsart_id = $request->input('zahlungsart_id');

        if ($zahlung->betrag > 0) {
            $zahlung->typ = 'Einnahme';
        } else {
            $zahlung->typ = 'Ausgabe';
        }
        ;

        // Datei-Upload, falls eine Datei hochgeladen wurde
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('bills', 'public');
            $zahlung->file_path = $filePath;
        }
        // Speichern der Zahlung in der Datenbank
        $zahlung->save();

        // Umleitung zurück zur Übersicht mit einer Erfolgsmeldung
        return redirect()->route('zahlungen.index')->with('success', 'Zahlung erfolgreich erstellt!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'beschreibung' => 'required|string|max:255',
            'rechnungsnr' => 'nullable|string|max:50',
            'datum' => 'required|date',
            'betrag' => 'required|numeric',
            'zahlungsart_id' => 'required|exists:zahlungsarten,id',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $zahlung = Zahlung::findOrFail($id);
        $zahlung->beschreibung = $request->input('beschreibung');
        $zahlung->rechnungsnr = $request->input('rechnungsnr');
        $zahlung->datum = $request->input('datum');
        $zahlung->betrag = $request->input('betrag');
        $zahlung->zahlungsart_id = $request->input('zahlungsart_id');
        if ($zahlung->betrag > 0) {
            $zahlung->typ = 'Einnahme';
        } else {
            $zahlung->typ = 'Ausgabe';
        }
        ;

        if ($request->hasFile('file_path')) {
            // Alte Datei löschen, falls vorhanden
            if ($zahlung->file_path) {
                Storage::disk('public')->delete($zahlung->file_path);
            }
            // Neue Datei speichern
            $filePath = $request->file('file_path')->store('bills', 'public');
            $zahlung->file_path = $filePath;
        }


        $zahlung->save();

        return redirect()->route('zahlungen.index')->with('success', 'Zahlung erfolgreich aktualisiert!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $zahlung = Zahlung::findOrFail($id);
        $zahlung->delete();
        return redirect('/zahlungen')->with('success', 'Zahlung erfolgreich gelöscht!');
    }


}
