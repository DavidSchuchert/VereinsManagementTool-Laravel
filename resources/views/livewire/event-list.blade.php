<div>
    <div class="mb-6 space-y-4">
        {{-- Header --}}
        <div class="p-4 bg-white rounded-lg shadow-sm flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Veranstaltungen</h1>
                <p class="text-sm text-gray-500">Planen und verwalten Sie Vereins-Events.</p>
            </div>
            <button wire:click="$dispatch('open-event-form')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700">
                Neues Event erstellen
            </button>
        </div>

        {{-- Tabs & Search --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div x-data="{ active: @entangle('filterTab') }" class="flex bg-gray-100 p-1 rounded-lg w-fit">
                <button @click="active = 'upcoming'" :class="{ 'bg-white shadow text-purple-600': active === 'upcoming', 'text-gray-500 hover:text-gray-700': active !== 'upcoming' }" class="px-4 py-1.5 text-sm font-medium rounded-md transition-all">Anstehend</button>
                <button @click="active = 'past'" :class="{ 'bg-white shadow text-purple-600': active === 'past', 'text-gray-500 hover:text-gray-700': active !== 'past' }" class="px-4 py-1.5 text-sm font-medium rounded-md transition-all">Vergangen</button>
            </div>

            <div class="relative flex-1 max-w-xs">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Events suchen..." class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Events Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" wire:loading.class="opacity-50">
        @forelse($events as $event)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                {{-- Event Header --}}
                <div class="p-5 border-b border-gray-50">
                    <div class="flex justify-between items-start mb-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $event->event_date->isFuture() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $event->event_date->format('d.m.Y') }}
                        </span>
                        
                        @if(in_array($event->id, $userAttendances))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Angemeldet
                            </span>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 line-clamp-1">{{ $event->title }}</h3>
                    <p class="text-sm text-gray-500 flex items-center mt-1">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        {{ $event->location }}
                    </p>
                </div>

                {{-- Event Body --}}
                <div class="p-5 flex-1">
                    <p class="text-sm text-gray-600 line-clamp-3 mb-4">{{ $event->description ?: 'Keine Beschreibung vorhanden.' }}</p>
                    
                    <div class="flex items-center text-xs text-gray-400">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 01-9-4.992m9 4.992H21m-6-6a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        Teilnehmer: {{ $event->attendances_count }} {{ $event->max_attendees ? '/ ' . $event->max_attendees : '' }}
                    </div>
                </div>

                {{-- Event Footer --}}
                <div class="p-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                    <div class="flex space-x-2">
                        @if($event->event_date->isFuture())
                            <button wire:click="toggleAttendance({{ $event->id }})" 
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white {{ in_array($event->id, $userAttendances) ? 'bg-red-500 hover:bg-red-600' : 'bg-purple-600 hover:bg-purple-700' }}">
                                {{ in_array($event->id, $userAttendances) ? 'Abmelden' : 'Anmelden' }}
                            </button>
                        @endif
                        
                        <a href="{{ route('events.show', $event->id) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50">
                            Details
                        </a>
                    </div>

                    {{-- Admin Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="p-1.5 rounded-md text-gray-400 hover:bg-gray-200">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                        </button>
                        <div x-show="open" x-transition class="origin-bottom-right absolute right-0 bottom-full mb-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                            <div class="py-1">
                                <button wire:click="$dispatch('open-event-form', { id: {{ $event->id }} }); open = false;" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    Bearbeiten
                                </button>
                                <button @click="if(confirm('Event wirklich löschen?')) $wire.delete({{ $event->id }})" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                    Löschen
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-xl shadow-sm border border-gray-200">
                Keine Veranstaltungen gefunden.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>
</div>
