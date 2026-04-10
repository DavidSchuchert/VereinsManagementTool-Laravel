<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class EventForm extends Component
{
    public $showModal = false;
    public $eventId = null;

    // Form fields
    public $title;
    public $description;
    public $event_date;
    public $location;
    public $max_attendees;

    protected $listeners = ['open-event-form' => 'open'];

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date|after:today',
            'location' => 'required|string|max:255',
            'max_attendees' => 'nullable|integer|min:1',
        ];
    }

    public function open($id = null)
    {
        $this->resetValidation();
        
        if ($id) {
            $this->eventId = $id;
            $event = Event::findOrFail($id);
            $this->title = $event->title;
            $this->description = $event->description;
            $this->event_date = $event->event_date->format('Y-m-d\TH:i');
            $this->location = $event->location;
            $this->max_attendees = $event->max_attendees;
        } else {
            $this->resetExcept(['showModal']);
            $this->event_date = now()->addDays(1)->format('Y-m-d\T18:00');
            $this->eventId = null;
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->event_date,
            'location' => $this->location,
            'max_attendees' => $this->max_attendees,
        ];

        if ($this->eventId) {
            Event::find($this->eventId)->update($data);
        } else {
            Event::create($data);
        }

        $this->showModal = false;
        $this->dispatch('refresh-event-list');
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $this->eventId ? 'Event erfolgreich aktualisiert.' : 'Event erfolgreich angelegt.'
        ]);
    }

    public function render()
    {
        return view('livewire.event-form');
    }
}
