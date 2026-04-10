<div>
    <div class="mb-4 space-y-4">
        {{-- Header and Statistics --}}
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <h1 class="text-2xl font-bold text-gray-800">Inventar-Datenbank</h1>
            <p class="text-gray-600">
                Artikelanzahl: <b class="text-blue-600">{{ $items->total() }}</b>
            </p>
        </div>

        {{-- Search and Filter Controls --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="relative flex-1">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Suche nach Artikel, EAN oder Standort..." 
                    class="w-full px-4 py-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            
            <div class="flex items-center gap-2">
                <select 
                    wire:model.live="filterCategory" 
                    class="px-4 py-2 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Alle Kategorien</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                
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
    </div>

    <div class="inventar">
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <button wire:click="$dispatch('open-inventar-form')" class="Neu-btn">Neuen Artikel erstellen</button>
            <a href="{{ route('inventar.exportPdf', ['search' => $search, 'filterCategory' => $filterCategory]) }}" 
               class="btn btn-primary export_btn">🖨️Exportieren als PDF</a>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow" wire:loading.class="opacity-50">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artikel / EAN</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategorie</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menge</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Details</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" x-data="{ openItem: null }">
                    @forelse ($items as $item)
                        <tr class="hover:bg-gray-50 cursor-pointer transition-colors" @click="openItem = (openItem === {{ $item->id }} ? null : {{ $item->id }})">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->artikel }}</div>
                                <div class="text-sm text-gray-500">EAN: {{ $item->ean }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $item->category->name ?? 'Keine' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->menge }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': openItem === {{ $item->id }} }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </td>
                        </tr>
                        
                        {{-- Details Row --}}
                        <tr x-show="openItem === {{ $item->id }}" x-transition x-cloak class="bg-gray-50">
                            <td colspan="4" class="px-6 py-4">
                                <div class="flex flex-col md:flex-row md:justify-between items-start gap-4">
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-700"><b>Lagerstandort:</b> {{ $item->lagerstandort }}</p>
                                        <p class="text-sm text-gray-700"><b>Bemerkungen:</b> {{ $item->bemerkung }}</p>
                                    </div>
                                    <div class="relative flex items-center space-x-4" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                            Optionen
                                            <svg class="-mr-1 ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                        </button>

                                        <div x-show="open" x-transition class="origin-top-right absolute right-0 mt-8 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                            <div class="py-1" role="menu">
                                                <button wire:click="$dispatch('open-inventar-form', { id: {{ $item->id }} }); open = false;" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <img src="{{ asset('images/edit-svgrepo-com.svg') }}" class="w-4 h-4 mr-2"> Bearbeiten
                                                </button>
                                                
                                                <form action="{{ route('inventar.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Wirklich löschen?');">
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
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                Keine Artikel gefunden, die Ihrer Suche entsprechen.
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
