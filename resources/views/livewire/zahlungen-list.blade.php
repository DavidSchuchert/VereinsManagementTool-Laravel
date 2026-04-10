<div>
    <div class="mb-4 space-y-4">
        {{-- Header and Bilanz --}}
        <div class="p-4 bg-white rounded-lg shadow-sm border-l-4 {{ $bilanz >= 0 ? 'border-green-500' : 'border-red-500' }}">
            <h1 class="text-2xl font-bold text-gray-800">Transaktions-Datenbank</h1>
            <div class="mt-2 flex flex-wrap gap-4">
                <div class="text-sm">
                    Aktueller Stand (gefiltert): <b class="{{ $bilanz >= 0 ? 'text-green-600' : 'text-red-600' }} text-lg">{{ number_format($bilanz, 2, ',', '.') }} €</b>
                </div>
                <div class="text-xs text-gray-500 self-center">
                    (Einnahmen: {{ number_format($totalEinnahmen, 2, ',', '.') }} € | Ausgaben: {{ number_format($totalAusgaben, 2, ',', '.') }} €)
                </div>
            </div>
        </div>

        {{-- Search and Filter Controls --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-gray-500 mb-1">Suche</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Beschreibung, R.-Nr..." class="w-full px-3 py-2 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Typ</label>
                <select wire:model.live="filterTyp" class="w-full px-3 py-2 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Alle Typen</option>
                    <option value="Einnahme">Einnahme</option>
                    <option value="Ausgabe">Ausgabe</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Zahlungsart</label>
                <select wire:model.live="filterZahlungsart" class="w-full px-3 py-2 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Alle Arten</option>
                    @foreach($zahlungsarten as $art)
                        <option value="{{ $art->id }}">{{ $art->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Von Datum</label>
                <input type="date" wire:model.live="dateFrom" class="w-full px-3 py-2 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Bis Datum</label>
                <input type="date" wire:model.live="dateTo" class="w-full px-3 py-2 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            
            <div class="flex items-end">
                <button wire:click="$set('search', ''); $set('filterTyp', ''); $set('filterZahlungsart', ''); $set('dateFrom', ''); $set('dateTo', '');" class="text-xs text-blue-600 hover:text-blue-800 underline mb-2">Filter zurücksetzen</button>
            </div>
        </div>
    </div>

    <div class="zahlungen">
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <button wire:click="$dispatch('open-zahlung-form')" class="Neu-btn">Neue Transaktion erfassen</button>
            <a href="{{ route('zahlungen.exportPdf', ['search' => $search, 'filterTyp' => $filterTyp, 'filterZahlungsart' => $filterZahlungsart, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo]) }}" 
               class="btn btn-primary export_btn">🖨️Exportieren als PDF</a>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow" wire:loading.class="opacity-50">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details / Datum</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Betrag / Art</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" x-data="{ openId: null }">
                    @forelse ($items as $item)
                        <tr class="hover:bg-gray-50 cursor-pointer transition-colors" @click="openId = (openId === {{ $item->id }} ? null : {{ $item->id }})">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $item->beschreibung }}</div>
                                <div class="text-xs text-gray-500">R.-Nr: {{ $item->rechnungsnr ?: '-' }} | {{ \Carbon\Carbon::parse($item->datum)->format('d.m.Y') }}</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="text-sm font-bold {{ $item->typ === 'Einnahme' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $item->typ === 'Einnahme' ? '+' : '-' }} {{ number_format($item->betrag, 2, ',', '.') }} €
                                </div>
                                <div class="text-xs text-gray-500">{{ $item->zahlungsart->name }}</div>
                            </td>
                        </tr>
                        
                        {{-- Extra Details Row --}}
                        <tr x-show="openId === {{ $item->id }}" x-transition x-cloak class="bg-gray-50">
                            <td colspan="2" class="px-6 py-4">
                                <div class="flex flex-col md:flex-row md:justify-between items-center gap-4">
                                    <div class="text-xs text-gray-400 space-y-1">
                                        <p>Erstellt am: {{ $item->created_at->format('d.m.Y H:i') }}</p>
                                        <p>Zuletzt bearbeitet: {{ $item->updated_at->format('d.m.Y H:i') }}</p>
                                    </div>
                                    <div class="relative flex items-center space-x-3" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                            Optionen
                                            <svg class="-mr-1 ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                        </button>

                                        <div x-show="open" x-transition class="origin-top-right absolute right-0 mt-8 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                            <div class="py-1" role="menu">
                                                <button wire:click="$dispatch('open-zahlung-form', { id: {{ $item->id }} }); open = false;" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <img src="{{ asset('images/edit-svgrepo-com.svg') }}" class="w-4 h-4 mr-2"> Bearbeiten
                                                </button>
                                                
                                                @if ($item->file_path)
                                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                        <img src="{{ asset('images/file-svgrepo-com.svg') }}" class="w-4 h-4 mr-2"> Datei anzeigen
                                                    </a>
                                                @endif

                                                <form action="{{ route('zahlungen.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Wirklich löschen?');">
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-12 text-center text-gray-500">
                                Keine Transaktionen gefunden.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $items->links() }}
        </div>
    </div>
</div>
