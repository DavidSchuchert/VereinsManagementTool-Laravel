<?php

namespace App\Livewire;

use App\Models\Mitglied;
use App\Models\Rangart;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class MembersForm extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $memberId = null;

    // Form fields
    public $mitgliedsnummer;
    public $vorname;
    public $nachname;
    public $geburtsdatum;
    public $plz;
    public $ort;
    public $strasse;
    public $hausnummer;
    public $telefon;
    public $email;
    public $eintrittsdatum;
    public $austrittsdatum;
    public $rang_id;
    public $file;
    public $existingFile;

    protected $listeners = ['open-member-form' => 'open'];

    protected function rules()
    {
        return [
            'mitgliedsnummer' => 'required|string|max:255|unique:mitglieder,mitgliedsnummer,' . $this->memberId,
            'vorname' => 'required|string|max:255',
            'nachname' => 'required|string|max:255',
            'geburtsdatum' => 'required|date',
            'plz' => 'required|integer',
            'ort' => 'required|string|max:255',
            'strasse' => 'required|string|max:255',
            'hausnummer' => 'required|string|max:255',
            'telefon' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'eintrittsdatum' => 'required|date',
            'austrittsdatum' => 'nullable|date',
            'rang_id' => 'required|exists:rangarten,id',
            'file' => 'nullable|file|max:10240', // 10MB
        ];
    }

    public function open($id = null)
    {
        $this->resetValidation();
        $this->reset(['file', 'existingFile']);
        
        if ($id) {
            $this->memberId = $id;
            $member = Mitglied::findOrFail($id);
            $this->mitgliedsnummer = $member->mitgliedsnummer;
            $this->vorname = $member->vorname;
            $this->nachname = $member->nachname;
            $this->geburtsdatum = $member->geburtsdatum;
            $this->plz = $member->plz;
            $this->ort = $member->ort;
            $this->strasse = $member->strasse;
            $this->hausnummer = $member->hausnummer;
            $this->telefon = $member->telefon;
            $this->email = $member->email;
            $this->eintrittsdatum = $member->eintrittsdatum;
            $this->austrittsdatum = $member->austrittsdatum;
            $this->rang_id = $member->rang_id;
            $this->existingFile = $member->file_path;
        } else {
            $this->resetExcept(['showModal']);
            $this->memberId = null;
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'mitgliedsnummer' => $this->mitgliedsnummer,
            'vorname' => $this->vorname,
            'nachname' => $this->nachname,
            'geburtsdatum' => $this->geburtsdatum,
            'plz' => $this->plz,
            'ort' => $this->ort,
            'strasse' => $this->strasse,
            'hausnummer' => $this->hausnummer,
            'telefon' => $this->telefon,
            'email' => $this->email,
            'eintrittsdatum' => $this->eintrittsdatum,
            'austrittsdatum' => $this->austrittsdatum,
            'rang_id' => $this->rang_id,
        ];

        if ($this->file) {
            if ($this->existingFile) {
                Storage::disk('public')->delete($this->existingFile);
            }
            $data['file_path'] = $this->file->store('mitglieder', 'public');
        }

        if ($this->memberId) {
            Mitglied::find($this->memberId)->update($data);
        } else {
            Mitglied::create($data);
        }

        $this->showModal = false;
        $this->dispatch('refresh-member-list');
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $this->memberId ? 'Mitglied erfolgreich aktualisiert.' : 'Mitglied erfolgreich angelegt.'
        ]);
    }

    public function render()
    {
        return view('livewire.members-form', [
            'rangarten' => Rangart::all(),
        ]);
    }
}
