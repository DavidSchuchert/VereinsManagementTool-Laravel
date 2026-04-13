<div>
    <div class="mb-6 space-y-4 animate-fade-in">
        {{-- Statistic Header --}}
        <div class="card-premium p-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div>
                <h1 class="text-2xl font-heading font-extrabold text-gray-900 tracking-tight">Finanz-Transaktionen</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Aktuelle Bilanz: <span class="font-bold {{ $bilanz >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ number_format($bilanz, 2, ',', '.') }} €</span>
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-3 bg-white/50 backdrop-blur-sm p-3 rounded-xl border border-white/50 shadow-sm">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Einnahmen</p>
                        <p class="text-sm font-bold text-emerald-700">{{ number_format($totalEinnahmen, 2, ',', '.') }} €</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/50 backdrop-blur-sm p-3 rounded-xl border border-white/50 shadow-sm">
                    <div class="w-10 h-10 rounded-lg bg-rose-50 flex items-center justify-center text-rose-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Ausgaben</p>
                        <p class="text-sm font-bold text-rose-700">{{ number_format($totalAusgaben, 2, ',', '.') }} €</p>
                    </div>
                </div>

                <div class="flex gap-2 ml-2">
                    <a href="{{ route('zahlungen.exportPdf', ['search' => $search, 'filterTyp' => $filterTyp, 'filterZahlungsart' => $filterZahlungsart, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo]) }}" 
                       class="btn-secondary py-2.5">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Export ({{ $dateRangeLabel }})
                    </a>
                    <button wire:click="$dispatch('open-zahlung-form')" class="btn-primary py-2.5">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Neu
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
                    placeholder="Suche nach Beschreibung oder Rechnungs-Nr..." 
                    class="block w-full pl-10 pr-3 py-2 border-transparent bg-transparent text-sm placeholder-gray-400 focus:border-transparent focus:ring-0 text-gray-900"
                >
            </div>
            
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                {{-- Date Pickers --}}
                <div class="flex items-center gap-2 bg-gray-50 px-3 py-1 rounded-lg border border-gray-100">
                    <input type="date" wire:model.live="dateFrom" class="bg-transparent border-none text-xs text-gray-600 focus:ring-0 p-0 w-28">
                    <span class="text-gray-300">→</span>
                    <input type="date" wire:model.live="dateTo" class="bg-transparent border-none text-xs text-gray-600 focus:ring-0 p-0 w-28">
                </div>

                <select wire:model.live="filterTyp" class="text-xs font-semibold text-gray-600 bg-gray-50 border-gray-100 rounded-lg focus:ring-accent-500 py-1.5">
                    <option value="">Alle Typen</option>
                    <option value="Einnahme">Einnahme</option>
                    <option value="Ausgabe">Ausgabe</option>
                </select>

                <select wire:model.live="filterZahlungsart" class="text-xs font-semibold text-gray-600 bg-gray-50 border-gray-100 rounded-lg focus:ring-accent-500 py-1.5">
                    <option value="">Alle Zahlungsarten</option>
                    @foreach($zahlungsarten as $art)
                        <option value="{{ $art->id }}">{{ $art->name }}</option>
                    @endforeach
                </select>

                <button wire:click="$set('search', ''); $set('filterTyp', ''); $set('filterZahlungsart', ''); $set('dateFrom', ''); $set('dateTo', '');" 
                        class="p-2 text-gray-400 hover:text-rose-500 transition-colors" title="Filter zurücksetzen">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Transactions List --}}
    <div class="space-y-3 animate-slide-up" wire:loading.class="opacity-60">
        @forelse ($items as $item)
            <div wire:key="zahlung-{{ $item->id }}" class="card-premium group hover:shadow-md transition-all">
                <div class="p-4 flex flex-col md:flex-row md:items-center gap-4">
                    
                    {{-- Status Icon & Description --}}
                    <div class="flex items-center gap-4 md:w-2/5">
                        <div class="w-12 h-12 rounded-xl flex-shrink-0 flex items-center justify-center shadow-sm {{ $item->typ === 'Einnahme' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                            @if($item->typ === 'Einnahme')
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"/></svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 line-clamp-1">{{ $item->beschreibung }}</h3>
                            <p class="text-[11px] text-gray-400 font-mono mt-0.5 uppercase">
                                {{ \Carbon\Carbon::parse($item->datum)->format('d. F Y') }}
                                @if($item->rechnungsnr)
                                    <span class="mx-1">&bull;</span> R.-Nr: {{ $item->rechnungsnr }}
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Metadata --}}
                    <div class="flex items-center gap-6 md:w-2/5 md:justify-center">
                        <div class="text-center">
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">Zahlungsart</p>
                            <p class="text-xs font-semibold text-gray-700">{{ $item->zahlungsart->name }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">Erfasst von</p>
                            <p class="text-xs font-semibold text-gray-700">{{ $item->user->name ?? 'System' }}</p>
                        </div>
                    </div>

                    {{-- Amount & Actions --}}
                    <div class="flex items-center justify-between md:justify-end md:w-1/5 pt-3 md:pt-0 border-t md:border-t-0 border-gray-100">
                        <div class="text-right mr-4">
                            <p class="text-base font-black {{ $item->typ === 'Einnahme' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $item->typ === 'Einnahme' ? '+' : '-' }} {{ number_format($item->betrag, 2, ',', '.') }} €
                            </p>
                        </div>
                        
                        <div class="flex items-center gap-1">
                            @if ($item->file_path)
                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="p-2 text-gray-400 hover:text-accent-600 hover:bg-accent-50 rounded-lg transition-colors" title="Beleg anzeigen">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                </a>
                            @endif
                            
                            <button wire:click="$dispatch('open-zahlung-form', { id: {{ $item->id }} })" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>

                            <form action="{{ route('zahlungen.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Möchtest du diese Transaktion wirklich löschen?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
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
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-heading font-medium text-gray-900">Keine Transaktionen gefunden</h3>
                <p class="mt-1 text-sm text-gray-500 max-w-sm">Für die gewählten Filter konnten wir keine Einträge finden.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $items->links(data: ['scrollTo' => false]) }}
    </div>
</div>
