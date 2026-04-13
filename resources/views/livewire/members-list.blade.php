<div>
    <div class="mb-6 space-y-4 animate-fade-in">
        {{-- Statistic Header --}}
        <div class="card-premium flex flex-col md:flex-row md:items-center justify-between p-6">
            <div>
                <h1 class="text-2xl font-heading font-extrabold text-gray-900 tracking-tight">Mitglieder</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Verwalte deine <span class="font-bold text-accent-600">{{ $members->total() }}</span> Mitglieder. 
                    <span class="text-gray-400">&bull;</span>
                    Davon <span class="text-rose-500 font-medium">{{ $members->whereNotNull('austrittsdatum')->count() }} ausgeschieden</span>
                </p>
            </div>
            <div class="mt-4 md:mt-0 flex flex-wrap gap-3">
                <a href="{{ route('mitglieder.exportPdf', ['search' => $search, 'filterStatus' => $filterStatus]) }}"
                    class="btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    PDF Export
                </a>
                <button wire:click="$dispatch('open-member-form')" class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Neues Mitglied
                </button>
            </div>
        </div>

        {{-- Filters & Search --}}
        <div class="card-premium p-2 flex flex-col md:flex-row gap-2">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Suche nach Name, ID oder E-Mail..." 
                    class="block w-full pl-10 pr-3 py-2.5 border-transparent bg-transparent text-sm placeholder-gray-400 focus:border-transparent focus:ring-0 text-gray-900"
                >
            </div>
            <div class="hidden md:block w-px bg-gray-200 my-2"></div>
            <div class="flex items-center gap-2 overflow-x-auto px-2 pb-2 md:pb-0 scrollbar-hide" x-data="{ activeTab: @entangle('filterStatus') }">
                <button @click="activeTab = 'all'" 
                        :class="activeTab === 'all' ? 'bg-gray-900 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'"
                        class="px-4 py-1.5 text-sm font-medium rounded-lg whitespace-nowrap transition-all duration-200">
                    Alle
                </button>
                <button @click="activeTab = 'active'" 
                        :class="activeTab === 'active' ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/20' : 'text-gray-600 hover:bg-gray-100'"
                        class="px-4 py-1.5 text-sm font-medium rounded-lg whitespace-nowrap transition-all duration-200">
                    Aktiv
                </button>
                <button @click="activeTab = 'inactive'" 
                        :class="activeTab === 'inactive' ? 'bg-rose-500 text-white shadow-md shadow-rose-500/20' : 'text-gray-600 hover:bg-gray-100'"
                        class="px-4 py-1.5 text-sm font-medium rounded-lg whitespace-nowrap transition-all duration-200">
                    Ausgeschieden
                </button>
                <div class="w-px bg-gray-300 h-5 mx-1"></div>
                <select wire:model.live="perPage" class="border-none bg-transparent py-1.5 pl-3 pr-8 text-sm font-medium text-gray-600 focus:ring-0 cursor-pointer">
                    <option value="10">10 / Seite</option>
                    <option value="25">25 / Seite</option>
                    <option value="50">50 / Seite</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Skeleton Loader --}}
    <div wire:loading.flex class="flex-col space-y-4">
        @foreach(range(1, 4) as $i)
            <div class="h-20 w-full skeleton"></div>
        @endforeach
    </div>

    {{-- Members Grid (Mobile: Cards, Desktop: Responsive Wide Cards) --}}
    <div class="space-y-4 animate-slide-up" wire:loading.remove>
        @forelse ($members as $mitglied)
            <div wire:key="member-{{ $mitglied->id }}" class="card-premium overflow-hidden group">
                <div class="p-5 flex flex-col md:flex-row md:items-center gap-4">
                    
                    {{-- Avatar & Identity (Clickable) --}}
                    <div class="flex items-center gap-4 md:w-1/3 cursor-pointer group-hover:opacity-80 transition-all" 
                         wire:click="$dispatch('show-member-details', { id: {{ $mitglied->id }} })">
                        <div class="w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center font-heading font-bold text-lg shadow-sm {{ $mitglied->austrittsdatum ? 'bg-rose-50 text-rose-500' : 'bg-accent-100 text-accent-700' }}">
                            {{ substr($mitglied->vorname, 0, 1) }}{{ substr($mitglied->nachname, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 group-hover:text-accent-600 transition-colors">
                                {{ $mitglied->vorname }} {{ $mitglied->nachname }}
                            </h3>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-xs font-semibold text-gray-500">#{{ $mitglied->mitgliedsnummer }}</span>
                                <span class="text-gray-300">&bull;</span>
                                @if($mitglied->austrittsdatum)
                                    <span class="badge-danger">Ausgeschieden</span>
                                @else
                                    <span class="badge-success">Aktiv</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Contact Info (Clickable) --}}
                    <div class="flex flex-col gap-1 md:w-1/3 text-sm cursor-pointer group-hover:opacity-80 transition-all"
                         wire:click="$dispatch('show-member-details', { id: {{ $mitglied->id }} })">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $mitglied->email ?? 'Keine E-Mail' }}
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $mitglied->telefon ?? 'Keine Telefonnummer' }}
                        </div>
                    </div>

                    {{-- Role & Actions --}}
                    <div class="flex items-center justify-between md:justify-end md:w-1/3 mt-2 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-gray-100">
                        <div class="md:hidden">
                            <span class="badge-accent">{{ $mitglied->rangart->name }}</span>
                        </div>
                        
                        <div class="flex items-center justify-end gap-2 w-full md:w-auto">
                            <span class="hidden md:inline-flex badge-accent mr-3">{{ $mitglied->rangart->name }}</span>
                            
                            @if ($mitglied->file_path)
                                <a href="{{ asset('storage/' . $mitglied->file_path) }}" target="_blank" class="p-2 text-gray-400 hover:text-accent-600 hover:bg-accent-50 rounded-lg transition-colors" title="Dokument anzeigen">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                </a>
                            @endif
                            
                            <button wire:click="$dispatch('open-member-form', { id: {{ $mitglied->id }} })" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Bearbeiten">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            
                            <form action="{{ route('mitglieder.destroy', $mitglied->id) }}" method="POST" onsubmit="return confirm('Möchtest du das Mitglied {{ $mitglied->vorname }} {{ $mitglied->nachname }} wirklich endgültig löschen?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Löschen">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card-premium p-12 text-center flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-lg font-heading font-medium text-gray-900">Keine Mitglieder gefunden</h3>
                <p class="mt-1 text-sm text-gray-500 max-w-sm mb-6">Für die ausgewählten Filterkriterien wurden keine Mitglieder in der Datenbank gefunden.</p>
                <button wire:click="$dispatch('open-member-form')" class="btn-primary">Jetzt anlegen</button>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $members->links(data: ['scrollTo' => false]) }}
    </div>
</div>
