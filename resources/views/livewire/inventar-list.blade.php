<div>
    <div class="mb-6 space-y-4 animate-fade-in">
        {{-- Statistic Header --}}
        <div class="card-premium p-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div>
                <h1 class="text-2xl font-heading font-extrabold text-gray-900 tracking-tight">Inventar & Bestand</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Verwaltung von <span class="font-bold text-accent-600">{{ $totalItems }}</span> verschiedenen Artikeltypen.
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-3 bg-white/50 backdrop-blur-sm p-3 rounded-xl border border-white/50 shadow-sm">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Gesamtbestand</p>
                        <p class="text-sm font-bold text-blue-700">{{ number_format($totalQuantity, 0, ',', '.') }} Einheiten</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/50 backdrop-blur-sm p-3 rounded-xl border border-white/50 shadow-sm">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Kategorien</p>
                        <p class="text-sm font-bold text-purple-700">{{ $totalCategories }} Gruppen</p>
                    </div>
                </div>

                <div class="flex gap-2 ml-2">
                    <a href="{{ route('inventar.exportPdf', ['search' => $search, 'filterCategory' => $filterCategory]) }}" 
                       class="btn-secondary py-2.5">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        PDF Export
                    </a>
                    <button wire:click="$dispatch('open-inventar-form')" class="btn-primary py-2.5">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Anlegen
                    </button>
                </div>
            </div>
        </div>

        {{-- Filters & Search --}}
        <div class="card-premium p-4 flex flex-col md:flex-row gap-4 items-center">
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Suche nach Artikel, EAN, Standort..." 
                    class="block w-full pl-10 pr-3 py-2 border-transparent bg-transparent text-sm placeholder-gray-400 focus:border-transparent focus:ring-0 text-gray-900"
                >
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <select wire:model.live="filterCategory" class="text-xs font-semibold text-gray-600 bg-gray-50 border-gray-100 rounded-lg focus:ring-accent-500 py-1.5">
                    <option value="">Alle Kategorien</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <select wire:model.live="filterLocation" class="text-xs font-semibold text-gray-600 bg-gray-50 border-gray-100 rounded-lg focus:ring-accent-500 py-1.5">
                    <option value="">Alle Standorte</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>

                <select wire:model.live="perPage" class="text-xs font-semibold text-gray-600 bg-gray-50 border-gray-100 rounded-lg focus:ring-accent-500 py-1.5">
                    <option value="10">10 / Seite</option>
                    <option value="25">25 / Seite</option>
                    <option value="50">50 / Seite</option>
                </select>

                <button wire:click="$set('search', ''); $set('filterCategory', ''); $set('filterLocation', '');" 
                        class="p-2 text-gray-400 hover:text-rose-500 transition-colors" title="Filter zurücksetzen">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Inventory Cards List --}}
    <div class="grid grid-cols-1 gap-4 animate-slide-up" wire:loading.class="opacity-60">
        @forelse ($items as $item)
            <div wire:key="item-{{ $item->id }}" class="card-premium group hover:shadow-md transition-all overflow-hidden" x-data="{ expanded: false }">
                <div class="p-5 flex flex-col md:flex-row md:items-center gap-4">
                    
                    {{-- Icon & Main Info --}}
                    <div class="flex items-center gap-4 md:w-2/5 cursor-pointer" @click="expanded = !expanded">
                        <div class="w-14 h-14 rounded-2xl flex-shrink-0 flex items-center justify-center shadow-sm bg-accent-50 text-accent-600 group-hover:bg-accent-600 group-hover:text-white transition-all duration-300">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 group-hover:text-accent-600 transition-colors">{{ $item->artikel }}</h3>
                            <p class="text-xs text-gray-400 font-mono mt-0.5">EAN: {{ $item->ean ?: 'N/A' }}</p>
                        </div>
                    </div>

                    {{-- Category & Location --}}
                    <div class="flex items-center gap-6 md:w-2/5">
                        <div class="flex-1">
                            <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest">Kategorie</p>
                            <span class="inline-flex items-center rounded-lg bg-purple-50 px-2 py-0.5 text-xs font-bold text-purple-700 mt-1 border border-purple-100">
                                {{ $item->category->name ?? 'Keine' }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest">Standort</p>
                            <p class="text-sm font-semibold text-gray-700 mt-0.5 line-clamp-1 truncate" title="{{ $item->location->name ?? 'Nicht angegeben' }}">
                                {{ $item->location->name ?? 'Nicht angegeben' }}
                            </p>
                        </div>
                    </div>

                    {{-- Quantity & Actions --}}
                    <div class="flex items-center justify-between md:justify-end md:w-1/5 pt-4 md:pt-0 border-t md:border-t-0 border-gray-100">
                        <div class="text-right mr-6">
                            <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest">Bestand</p>
                            <p class="text-lg font-black text-gray-900">{{ $item->menge }}</p>
                        </div>
                        
                        <div class="flex items-center gap-1">
                            <button @click="expanded = !expanded" class="p-2 text-gray-400 hover:text-accent-600 hover:bg-accent-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-180': expanded }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <button wire:click="$dispatch('open-inventar-form', { id: {{ $item->id }} })" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form action="{{ route('inventar.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Möchtest du diesen Artikel wirklich aus dem Inventar löschen?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Expanded Details --}}
                <div x-show="expanded" x-collapse>
                    <div class="px-5 pb-5 pt-0 border-t border-gray-50 bg-gray-50/50">
                        <div class="p-4 rounded-xl bg-white/60 border border-white/80 shadow-inner mt-4">
                            <h4 class="text-[11px] uppercase font-black text-gray-400 tracking-widest mb-2">Bemerkungen & Zusatzinfos</h4>
                            <p class="text-sm text-gray-600 italic">
                                {{ $item->bemerkung ?: 'Keine zusätzlichen Bemerkungen hinterlegt.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card-premium p-12 text-center flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <h3 class="text-lg font-heading font-medium text-gray-900">Keine Artikel im Inventar</h3>
                <p class="mt-1 text-sm text-gray-500 max-w-sm mb-6">Für die ausgewählten Filterkriterien wurden keine Einträge in der Datenbank gefunden.</p>
                <button wire:click="$dispatch('open-inventar-form')" class="btn-primary">Jetzt ersten Artikel anlegen</button>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $items->links(data: ['scrollTo' => false]) }}
    </div>
</div>
