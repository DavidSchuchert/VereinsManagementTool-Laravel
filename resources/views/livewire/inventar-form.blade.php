<div x-data="{ open: @entangle('showModal') }" 
     @keydown.window.escape="open = false" 
     x-show="open" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true"
     style="display: none;">
    
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        {{-- Background backdrop --}}
        <div x-show="open" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" 
             @click="open = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="open" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            
            <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                <button type="button" 
                        class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" 
                        @click="open = false">
                    <span class="sr-only">Schließen</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                        {{ $itemId ? 'Artikel bearbeiten' : 'Neuen Artikel hinzufügen' }}
                    </h3>
                    
                    <form wire:submit.prevent="save" class="mt-6 space-y-4">
                        {{-- Artikelname --}}
                        <div>
                            <label for="artikel" class="block text-sm font-medium text-gray-700">Artikelbezeichnung</label>
                            <input type="text" wire:model="artikel" id="artikel" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('artikel') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- EAN / Code --}}
                        <div>
                            <label for="ean" class="block text-sm font-medium text-gray-700">EAN / Barcode</label>
                            <input type="text" wire:model="ean" id="ean" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('ean') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- Menge --}}
                            <div>
                                <label for="menge" class="block text-sm font-medium text-gray-700">Bestand / Menge</label>
                                <input type="number" wire:model="menge" id="menge" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('menge') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            {{-- Kategorie --}}
                            <div>
                                <label for="kategorie_id" class="block text-sm font-medium text-gray-700">Kategorie</label>
                                <select wire:model="kategorie_id" id="kategorie_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
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
                            <label for="lagerstandort" class="block text-sm font-medium text-gray-700">Lagerstandort</label>
                            <input type="text" wire:model="lagerstandort" id="lagerstandort" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('lagerstandort') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- Bemerkung --}}
                        <div>
                            <label for="bemerkung" class="block text-sm font-medium text-gray-700">Bemerkung</label>
                            <textarea wire:model="bemerkung" id="bemerkung" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                            @error('bemerkung') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Speichern
                            </button>
                            <button type="button" @click="open = false" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                                Abbrechen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
