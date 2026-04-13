<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class LookupManager extends Component
{
    public $type; // 'rangart', 'category', 'zahlungsart'
    public $title;
    public $newName;
    public $editingId = null;
    public $editingName = '';
    public $extraData = [];

    protected $rules = [
        'newName' => 'required|string|min:2|max:255',
        'editingName' => 'required|string|min:2|max:255',
    ];

    public function mount($type, $title, $extraData = [])
    {
        $this->type = $type;
        $this->title = $title;
        $this->extraData = $extraData;
    }

    public function getModelClass()
    {
        return match ($this->type) {
            'rangart' => \App\Models\Rangart::class,
            'category' => \App\Models\Category::class,
            'zahlungsart' => \App\Models\Zahlungsart::class,
            default => throw new \Exception("Unknown type: {$this->type}"),
        };
    }

    public function save()
    {
        $this->validateOnly('newName');

        $modelClass = $this->getModelClass();
        $modelClass::create(array_merge(['name' => $this->newName], $this->extraData));

        $this->newName = '';
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "{$this->title} wurde erfolgreich hinzugefügt."
        ]);
    }

    public function startEdit($id, $name)
    {
        $this->editingId = $id;
        $this->editingName = $name;
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->editingName = '';
    }

    public function update()
    {
        $this->validateOnly('editingName');

        $modelClass = $this->getModelClass();
        $item = $modelClass::findOrFail($this->editingId);
        $item->update(['name' => $this->editingName]);

        $this->cancelEdit();
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "{$this->title} wurde aktualisiert."
        ]);
    }

    public function delete($id)
    {
        $modelClass = $this->getModelClass();
        $item = $modelClass::findOrFail($id);
        
        // Prevent deletion if in use (optional but good)
        // For simplicity we just soft delete if the model supports it
        $item->delete();

        $this->dispatch('notify', [
            'type' => 'info',
            'message' => "{$this->title} wurde entfernt."
        ]);
    }

    public function render()
    {
        $modelClass = $this->getModelClass();
        $query = $modelClass::query();
        
        if (!empty($this->extraData)) {
            $query->where($this->extraData);
        }

        return view('livewire.lookup-manager', [
            'items' => $query->orderBy('name')->get()
        ]);
    }
}
