<div x-data="{ open: @entangle('showModal') }" 
     @keydown.window.escape="open = false" 
     x-show="open" 
     class="relative z-50" 
     aria-labelledby="slide-over-title" 
     role="dialog" 
     aria-modal="true"
     style="display: none;">
    
    <div x-show="open" 
         x-transition:enter="ease-in-out duration-500" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="ease-in-out duration-500" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         class="fixed inset-0 transition-opacity bg-gray-900/80"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 pointer-events-none">
                <div x-show="open" 
                     x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" 
                     x-transition:enter-start="translate-x-full" 
                     x-transition:enter-end="translate-x-0" 
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" 
                     x-transition:leave-start="translate-x-0" 
                     x-transition:leave-end="translate-x-full" 
                     class="w-screen max-w-md pointer-events-auto"
                     @click.away="open = false">
                    
                    <form wire:submit.prevent="save" class="flex flex-col h-full bg-white shadow-xl">
                        <div class="flex-1 h-0 overflow-y-auto">
                            <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-medium text-white" id="slide-over-title">
                                        {{ $itemId ? 'Artikel bearbeiten' : 'Neuen Artikel hinzufügen' }}
                                    </h2>
                                    <div class="flex items-center ml-3 h-7">
                                        <button type="button" class="text-indigo-200 bg-indigo-700 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white" @click="open = false">
                                            <span class="sr-only">Schließen</span>
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col justify-between flex-1">
                                <div class="px-4 py-6 space-y-6 sm:px-6">
                                    {{-- Artikelname --}}
                                    <div>
                                        <label for="artikel" class="block text-sm font-medium text-gray-900">Artikelbezeichnung</label>
                                        <input type="text" wire:model="artikel" id="artikel" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @error('artikel') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- EAN --}}
                                    <div>
                                        <label for="ean" class="block text-sm font-medium text-gray-900">EAN / Barcode</label>
                                        <input type="text" wire:model="ean" id="ean" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @error('ean') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        {{-- Menge --}}
                                        <div>
                                            <label for="menge" class="block text-sm font-medium text-gray-900">Bestand</label>
                                            <input type="number" wire:model="menge" id="menge" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            @error('menge') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- Kategorie --}}
                                        <div>
                                            <label for="kategorie_id" class="block text-sm font-medium text-gray-900">Kategorie</label>
                                            <select wire:model="kategorie_id" id="kategorie_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="">Wählen...</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('kategorie_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    {{-- Lagerstandort --}}
                                    <div>
                                        <label for="location_id" class="block text-sm font-medium text-gray-900">Lagerstandort</label>
                                        <select wire:model="location_id" id="location_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">Standort wählen...</option>
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('location_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Bemerkung --}}
                                    <div>
                                        <label for="bemerkung" class="block text-sm font-medium text-gray-900">Bemerkung</label>
                                        <textarea wire:model="bemerkung" id="bemerkung" rows="4" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                        @error('bemerkung') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end flex-shrink-0 px-4 py-4 space-x-3 border-t border-gray-200">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50" @click="open = false">Abbrechen</button>
                            <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <span wire:loading.remove wire:target="save">Speichern</span>
                                <span wire:loading wire:target="save">Speichert...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
