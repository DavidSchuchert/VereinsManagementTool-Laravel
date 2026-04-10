<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\EventAttendance as Attendance;
use Livewire\Component;

class EventAttendance extends Component
{
    public Event $event;
    public $search = '';

    public function toggleAttended($attendanceId)
    {
        // Spatie Permission Check (Admin/Manager only)
        if (!auth()->user()->can('manage events') && !auth()->user()->hasRole('admin')) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Keine Berechtigung.']);
            return;
        }

        $attendance = Attendance::findOrFail($attendanceId);
        $attendance->attended = !$attendance->attended;
        $attendance->save();

        $this->dispatch('notify', [
            'type' => 'success', 
            'message' => $attendance->attended ? 'Teilnehmer als anwesend markiert.' : 'Anwesenheit entfernt.'
        ]);
    }

    public function render()
    {
        $attendances = $this->event->attendances()
            ->with('user')
            ->whereHas('user', function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->get();

        return view('livewire.event-attendance', [
            'attendances' => $attendances,
        ]);
    }
}
