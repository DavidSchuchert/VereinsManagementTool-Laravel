<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\EventAttendance;
use App\Services\FilterService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class EventList extends Component
{
    use WithPagination;

    public $search = '';
    public $filterTab = 'upcoming'; // 'upcoming', 'past'
    public $perPage = 10;

    protected $listeners = ['refresh-event-list' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterTab' => ['except' => 'upcoming'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleAttendance($eventId)
    {
        $attendance = EventAttendance::where('event_id', $eventId)
            ->where('user_id', Auth::id())
            ->first();

        if ($attendance) {
            $attendance->delete();
            $this->dispatch('notify', ['type' => 'info', 'message' => 'Abmeldung erfolgreich.']);
        } else {
            $event = Event::findOrFail($eventId);
            if ($event->isFull()) {
                $this->dispatch('notify', ['type' => 'error', 'message' => 'Dieses Event ist leider bereits ausgebucht.']);
                return;
            }

            EventAttendance::create([
                'event_id' => $eventId,
                'user_id' => Auth::id(),
            ]);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Anmeldung erfolgreich.']);
        }
    }

    public function delete($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        $this->dispatch('notify', ['type' => 'info', 'message' => 'Event gelöscht.']);
    }

    public function render(FilterService $filterService)
    {
        $query = Event::withCount('attendances');

        if ($this->filterTab === 'upcoming') {
            $query->upcoming();
        } else {
            $query->past();
        }

        $filters = [
            'search' => $this->search,
            'search_columns' => ['title', 'location', 'description'],
        ];

        $events = $filterService->filter($query, $filters)->paginate($this->perPage);

        // Get user's attendance IDs for current page events
        $userAttendances = Auth::user() ? EventAttendance::whereIn('event_id', $events->pluck('id'))
            ->where('user_id', Auth::id())
            ->pluck('event_id')
            ->toArray() : [];

        return view('livewire.event-list', [
            'events' => $events,
            'userAttendances' => $userAttendances,
        ]);
    }
}
