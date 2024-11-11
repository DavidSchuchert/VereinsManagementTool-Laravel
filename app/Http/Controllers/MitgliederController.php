<?php

namespace App\Http\Controllers;

use App\Models\Mitglied;
use App\Models\Rangart;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Storage;

class MitgliederController extends Controller
{

    /* FILTERUNG */

    private function applyFilters(Request $request)
    {
        $query = Mitglied::query();

        if ($request->filled('suche')) {
            $query->where(function ($q) use ($request) {
                $q->where('vorname', 'like', '%' . $request->suche . '%')
                    ->orWhere('nachname', 'like', '%' . $request->suche . '%');
            });
        }

        if ($request->filled('geburtsdatum_von')) {
            $query->where('geburtsdatum', '>=', $request->geburtsdatum_von);
        }
        if ($request->filled('geburtsdatum_bis')) {
            $query->where('geburtsdatum', '<=', $request->geburtsdatum_bis);
        }


        if ($request->filled('plz')) {
            $query->where('plz', 'like', '%' . $request->plz . '%');
        }


        if ($request->filled('ort')) {
            $query->where('ort', 'like', '%' . $request->ort . '%');
        }

        if ($request->filled('strasse')) {
            $query->where('strasse', 'like', '%' . $request->strasse . '%');
        }

        if ($request->filled('rang_id')) {
            $query->where('rang_id', $request->rang_id);
        }

        if ($request->filled('eintritt_von')) {
            $query->where('eintrittsdatum', '>=', $request->eintritt_von);
        }
        if ($request->filled('eintritt_bis')) {
            $query->where('eintrittsdatum', '<=', $request->eintritt_bis);
        }

        if ($request->filled('mitgliedsnummer')) {
            $query->where('mitgliedsnummer', 'like', '%' . $request->mitgliedsnummer . '%');
        }

        if ($request->filled('ausgetreten')) {
            if ($request->ausgetreten === 'ja') {
                $query->whereNotNull('austrittsdatum');
            } elseif ($request->ausgetreten === 'nein') {
                $query->whereNull('austrittsdatum');
            }
        }

        return $query;
    }

    /* PDF EXPORT! */
    public function exportPdf(Request $request)
    {
        // Filter für Zahlungen anwenden
        $query = $this->applyFilters($request);

        $mitglieder = $query->orderBy('mitgliedsnummer', 'asc')->get();
        $pdf = Pdf::loadView('pdf.mitglieder', compact('mitglieder'))->setPaper('a4', 'landscape');

        return $pdf->download('mitglieder_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Mitglied::query();
        $meldung = null;

        // Filter für Zahlungen anwenden
        $query = $this->applyFilters($request);

        $mitglieder = $query->orderBy('id', 'desc')->paginate(15);

        $rangarten = Rangart::orderBy('id')->pluck('name', 'id');

        return view('mitglieder.index', compact('mitglieder', 'rangarten'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validierung der Eingaben
        $request->validate([
            'mitgliedsnummer' => 'required|string|max:255',
            'vorname' => 'required|string|max:255',
            'nachname' => 'required|string|max:255',
            'geburtsdatum' => 'required|date',
            'plz' => 'required|integer',
            'ort' => 'required|string|max:255',
            'strasse' => 'required|string|max:255',
            'hausnummer' => 'required|string|max:10',
            'telefon' => 'nullable|string|max:50',
            'email' => 'required|email|max:255',
            'eintrittsdatum' => 'required|date',
            'austrittsdatum' => 'nullable|date',
            'rang_id' => 'required|exists:rangarten,id',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Erstellen eines neuen Mitglied-Objekts
        $mitglied = new Mitglied();
        $mitglied->mitgliedsnummer = $request->input('mitgliedsnummer');
        $mitglied->vorname = $request->input('vorname');
        $mitglied->nachname = $request->input('nachname');
        $mitglied->geburtsdatum = $request->input('geburtsdatum');
        $mitglied->plz = $request->input('plz');
        $mitglied->ort = $request->input('ort');
        $mitglied->strasse = $request->input('strasse');
        $mitglied->hausnummer = $request->input('hausnummer');
        $mitglied->telefon = $request->input('telefon');
        $mitglied->email = $request->input('email');
        $mitglied->eintrittsdatum = $request->input('eintrittsdatum');
        $mitglied->austrittsdatum = $request->input('austrittsdatum');
        $mitglied->rang_id = $request->input('rang_id');

        // Datei-Upload, falls eine Datei hochgeladen wurde
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('members', 'public');
            $mitglied->file_path = $filePath;
        }

        // Speichern des Mitglieds in der Datenbank
        $mitglied->save();

        // Umleitung zurück zur Übersicht mit einer Erfolgsmeldung
        return redirect()->route('mitglieder.index')->with('success', 'Mitglied erfolgreich erstellt!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validierung der Eingaben
        $request->validate([
            'mitgliedsnummer' => 'required|string|max:255',
            'vorname' => 'required|string|max:255',
            'nachname' => 'required|string|max:255',
            'geburtsdatum' => 'required|date',
            'plz' => 'required|integer',
            'ort' => 'required|string|max:255',
            'strasse' => 'required|string|max:255',
            'hausnummer' => 'required|string|max:10',
            'telefon' => 'nullable|string|max:50',
            'email' => 'required|email|max:255',
            'eintrittsdatum' => 'required|date',
            'austrittsdatum' => 'nullable|date',
            'rang_id' => 'required|exists:rangarten,id',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Finde das bestehende Mitglied
        $mitglied = Mitglied::findOrFail($id);

        // Aktualisiere die Mitgliedsdaten
        $mitglied->mitgliedsnummer = $request->input('mitgliedsnummer');
        $mitglied->vorname = $request->input('vorname');
        $mitglied->nachname = $request->input('nachname');
        $mitglied->geburtsdatum = $request->input('geburtsdatum');
        $mitglied->plz = $request->input('plz');
        $mitglied->ort = $request->input('ort');
        $mitglied->strasse = $request->input('strasse');
        $mitglied->hausnummer = $request->input('hausnummer');
        $mitglied->telefon = $request->input('telefon');
        $mitglied->email = $request->input('email');
        $mitglied->eintrittsdatum = $request->input('eintrittsdatum');
        $mitglied->austrittsdatum = $request->input('austrittsdatum');
        $mitglied->rang_id = $request->input('rang_id');

        // Datei-Upload, falls eine Datei hochgeladen wurde
        if ($request->hasFile('file_path')) {
            // Alte Datei löschen, falls vorhanden
            if ($mitglied->file_path) {
                Storage::disk('public')->delete($mitglied->file_path);
            }
            // Neue Datei speichern
            $filePath = $request->file('file_path')->store('members', 'public');
            $mitglied->file_path = $filePath;
        }

        // Speichern der Änderungen in der Datenbank
        $mitglied->save();

        // Umleitung zurück zur Übersicht mit einer Erfolgsmeldung
        return redirect()->route('mitglieder.index')->with('success', 'Mitglied erfolgreich aktualisiert!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
