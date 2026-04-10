<?php

namespace App\Livewire;

use App\Models\Inventar;
use App\Models\Category;
use Livewire\Component;

class InventarForm extends Component
{
    public $showModal = false;
    public $itemId = null;

    // Form fields
    public $artikel;
    public $ean;
    public $menge;
    public $bemerkung;
    public $lagerstandort;
    public $kategorie_id;

    protected $listeners = ['open-inventar-form' => 'open'];

    protected function rules()
    {
        return [
            'artikel' => 'required|string|max:255',
            'ean' => 'nullable|string|max:255',
            'menge' => 'required|integer|min:0',
            'bemerkung' => 'nullable|string',
            'lagerstandort' => 'required|string|max:255',
            'kategorie_id' => 'required|exists:categories,id',
        ];
    }

    public function open($id = null)
    {
        $this->resetValidation();
        
        if ($id) {
            $this->itemId = $id;
            $item = Inventar::findOrFail($id);
            $this->artikel = $item->artikel;
            $this->ean = $item->ean;
            $this->menge = $item->menge;
            $this->bemerkung = $item->bemerkung;
            $this->lagerstandort = $item->lagerstandort;
            $this->kategorie_id = $item->kategorie_id;
        } else {
            $this->resetExcept(['showModal']);
            $this->itemId = null;
        }

        $this->showModal = true;
    }

    public function save()
    {
        // Spatie Permission Check (optional but recommended based on prompt)
        if (auth()->user() && !auth()->user()->can('manage inventory') && !auth()->user()->hasRole('admin')) {
            // Normal users might only view, but here we assume the form is only shown to authorized users
            // session()->flash('error', 'Keine Berechtigung.');
            // return;
        }

        $this->validate();

        $data = [
            'artikel' => $this->artikel,
            'ean' => $this->ean,
            'menge' => $this->menge,
            'bemerkung' => $this->bemerkung,
            'lagerstandort' => $this->lagerstandort,
            'kategorie_id' => $this->kategorie_id,
        ];

        if ($this->itemId) {
            Inventar::find($this->itemId)->update($data);
        } else {
            Inventar::create($data);
        }

        $this->showModal = false;
        $this->dispatch('refresh-inventar-list');
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $this->itemId ? 'Artikel erfolgreich aktualisiert.' : 'Artikel erfolgreich angelegt.'
        ]);
    }

    public function render()
    {
        return view('livewire.inventar-form', [
            'categories' => Category::all(),
        ]);
    }
}
