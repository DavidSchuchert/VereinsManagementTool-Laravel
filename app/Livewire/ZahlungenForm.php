<?php

namespace App\Livewire;

use App\Models\Zahlung;
use App\Models\Zahlungsart;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ZahlungenForm extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $zahlungId = null;

    // Form fields
    public $betrag;
    public $datum;
    public $zahlungsart_id;
    public $typ = 'Einnahme';
    public $beschreibung;
    public $rechnungsnr;
    public $file;
    public $existingFile;

    protected $listeners = ['open-zahlung-form' => 'open'];

    protected function rules()
    {
        return [
            'betrag' => 'required|numeric|min:0',
            'datum' => 'required|date',
            'zahlungsart_id' => 'required|exists:zahlungsarten,id',
            'typ' => 'required|in:Einnahme,Ausgabe',
            'beschreibung' => 'nullable|string',
            'rechnungsnr' => 'nullable|string|max:50',
            'file' => 'nullable|file|max:10240',
        ];
    }

    public function open($id = null)
    {
        $this->resetValidation();
        $this->reset(['file', 'existingFile']);
        
        if ($id) {
            $this->zahlungId = $id;
            $zahlung = Zahlung::findOrFail($id);
            $this->betrag = $zahlung->betrag;
            $this->datum = $zahlung->datum;
            $this->zahlungsart_id = $zahlung->zahlungsart_id;
            $this->typ = $zahlung->typ;
            $this->beschreibung = $zahlung->beschreibung;
            $this->rechnungsnr = $zahlung->rechnungsnr;
            $this->existingFile = $zahlung->file_path;
        } else {
            $this->resetExcept(['showModal', 'typ', 'datum']);
            $this->datum = now()->format('Y-m-d');
            $this->zahlungId = null;
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'betrag' => $this->betrag,
            'datum' => $this->datum,
            'zahlungsart_id' => $this->zahlungsart_id,
            'typ' => $this->typ,
            'beschreibung' => $this->beschreibung,
            'rechnungsnr' => $this->rechnungsnr,
        ];

        if ($this->file) {
            if ($this->existingFile) {
                Storage::disk('public')->delete($this->existingFile);
            }
            $data['file_path'] = $this->file->store('zahlungen', 'public');
        }

        if ($this->zahlungId) {
            Zahlung::find($this->zahlungId)->update($data);
        } else {
            Zahlung::create($data);
        }

        $this->showModal = false;
        $this->dispatch('refresh-zahlung-list');
    }

    public function render()
    {
        return view('livewire.zahlungen-form', [
            'zahlungsarten' => Zahlungsart::all(),
        ]);
    }
}
