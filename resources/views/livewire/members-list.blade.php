<div>
    <div class="mb-4 space-y-4">
        {{-- Statistic Header --}}
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <h1 class="text-2xl font-bold text-gray-800">Mitglieder-Datenbank</h1>
            <p class="text-gray-600">
                Mitgliederanzahl: <b class="text-blue-600">{{ $members->total() }}</b> 
                davon ausgeschieden: <b class="text-red-600">{{ $members->whereNotNull('austrittsdatum')->count() }}</b> (in dieser Ansicht)
            </p>
        </div>

        {{-- Search and Filter Controls --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="relative flex-1">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Suche nach Name, ID oder E-Mail..." 
                    class="w-full px-4 py-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            
            <div class="flex items-center gap-2">
                <select 
                    wire:model.live="perPage" 
                    class="px-4 py-2 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="10">10 pro Seite</option>
                    <option value="25">25 pro Seite</option>
                    <option value="50">50 pro Seite</option>
                </select>
            </div>
        </div>

        {{-- Alpine.js Tabs for Filtering Status --}}
        <div x-data="{ activeTab: @entangle('filterStatus') }" class="mb-6">
            <div class="flex border-b border-gray-200">
                <button 
                    @click="activeTab = 'all'" 
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'all', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'all' }"
                    class="px-6 py-2 font-medium transition-colors border-b-2"
                >
                    Alle
                </button>
                <button 
                    @click="activeTab = 'active'" 
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'active', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'active' }"
                    class="px-6 py-2 font-medium transition-colors border-b-2"
                >
                    Aktiv
                </button>
                <button 
                    @click="activeTab = 'inactive'" 
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'inactive', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'inactive' }"
                    class="px-6 py-2 font-medium transition-colors border-b-2"
                >
                    Ausgeschieden
                </button>
            </div>
        </div>
    </div>

    <div class="mitglieder">
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <button wire:click="$dispatch('open-member-form')" class="Neu-btn">Neues Mitglied anlegen</button>
            <a href="{{ route('mitglieder.exportPdf', ['search' => $search, 'filterStatus' => $filterStatus]) }}"
                class="btn btn-primary export_btn">🖨️Exportieren als PDF</a>
        </div>

        <div class="mitgliederliste" wire:loading.class="opacity-50">
            @forelse ($members as $mitglied)
                <details wire:key="member-{{ $mitglied->id }}">
                    <summary class="accordion_summary">
                        {{ $mitglied->vorname }} {{ $mitglied->nachname }}
                        @if($mitglied->austrittsdatum)
                            <span class="ml-2 text-xs font-normal text-red-500">(Ausgeschieden)</span>
                        @endif
                    </summary>
                    <div class="accordion_data">
                        <p><b>ID:</b> {{ $mitglied->mitgliedsnummer }}</p>
                        <p><b>Geburtstag:</b> {{ \Carbon\Carbon::parse($mitglied->geburtsdatum)->format('d.m.Y') }}</p>
                        <p><b>Telefon/Handy:</b> {{ $mitglied->telefon }}</p>
                        <p><b>E-Mail:</b> {{ $mitglied->email }}</p>
                        <p><b>Rang:</b> {{ $mitglied->rangart->name }}</p>
                        <p><b>Beitritt:</b> {{ \Carbon\Carbon::parse($mitglied->eintrittsdatum)->format('d.m.Y') }}</p>
                        <p><b>Austritt:</b> {{ $mitglied->austrittsdatum ? \Carbon\Carbon::parse($mitglied->austrittsdatum)->format('d.m.Y') : 'Nicht Ausgetreten' }}</p>
                        <p><b>Adresse:</b> {{ $mitglied->plz }}, {{ $mitglied->ort }}, {{ $mitglied->strasse }}
                            {{ $mitglied->hausnummer }}</p>
                    </div>
                    <div class="options" x-data="{ open: false }">
                        <div class="relative inline-block text-left">
                            <button @click="open = !open" @click.away="open = false" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                Optionen
                                <svg class="-mr-1 ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>

                            <div x-show="open" x-transition class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                <div class="py-1" role="menu" aria-orientation="vertical">
                                    <button wire:click="$dispatch('open-member-form', { id: {{ $mitglied->id }} }); open = false;" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <img src="{{ asset('images/edit-svgrepo-com.svg') }}" class="w-4 h-4 mr-2"> Bearbeiten
                                    </button>
                                    
                                    @if ($mitglied->file_path)
                                        <a href="{{ asset('storage/' . $mitglied->file_path) }}" target="_blank" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                            <img src="{{ asset('images/file-svgrepo-com.svg') }}" class="w-4 h-4 mr-2"> Datei anzeigen
                                        </a>
                                    @endif

                                    <form action="{{ route('mitglieder.destroy', $mitglied->id) }}" method="POST" onsubmit="return confirm('Wirklich löschen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                            <img src="{{ asset('images/delete-svgrepo-com.svg') }}" class="w-4 h-4 mr-2"> Löschen
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </details>
            @empty
                <div class="py-12 text-center text-gray-500">
                    Keine Mitglieder gefunden, die deiner Suche entsprechen.
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        {{ $members->links() }}
    </div>
</div>
