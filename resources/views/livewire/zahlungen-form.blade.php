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
                        {{ $zahlungId ? 'Zahlung bearbeiten' : 'Neue Zahlung erfassen' }}
                    </h3>
                    
                    <form wire:submit.prevent="save" class="mt-6 space-y-4">
                        <div class="flex items-center justify-center p-1 space-x-1 bg-gray-100 rounded-lg">
                            <button type="button" 
                                    wire:click="$set('typ', 'Einnahme')" 
                                    class="flex-1 px-4 py-2 text-sm font-medium rounded-md transition-colors {{ $typ === 'Einnahme' ? 'bg-green-600 text-white shadow' : 'text-gray-500 hover:text-gray-700' }}">
                                Einnahme
                            </button>
                            <button type="button" 
                                    wire:click="$set('typ', 'Ausgabe')" 
                                    class="flex-1 px-4 py-2 text-sm font-medium rounded-md transition-colors {{ $typ === 'Ausgabe' ? 'bg-red-600 text-white shadow' : 'text-gray-500 hover:text-gray-700' }}">
                                Ausgabe
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- Betrag --}}
                            <div>
                                <label for="betrag" class="block text-sm font-medium text-gray-700">Betrag (€)</label>
                                <input type="number" step="0.01" wire:model="betrag" id="betrag" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('betrag') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            {{-- Datum --}}
                            <div>
                                <label for="datum" class="block text-sm font-medium text-gray-700">Datum</label>
                                <input type="date" wire:model="datum" id="datum" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('datum') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Zahlungsart --}}
                        <div>
                            <label for="zahlungsart_id" class="block text-sm font-medium text-gray-700">Zahlungsart</label>
                            <select wire:model="zahlungsart_id" id="zahlungsart_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Wählen...</option>
                                @foreach($zahlungsarten as $art)
                                    <option value="{{ $art->id }}">{{ $art->name }}</option>
                                @endforeach
                            </select>
                            @error('zahlungsart_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- Rechnungsnummer --}}
                        <div>
                            <label for="rechnungsnr" class="block text-sm font-medium text-gray-700">Rechnungsnummer</label>
                            <input type="text" wire:model="rechnungsnr" id="rechnungsnr" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('rechnungsnr') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- Beschreibung --}}
                        <div>
                            <label for="beschreibung" class="block text-sm font-medium text-gray-700">Beschreibung</label>
                            <textarea wire:model="beschreibung" id="beschreibung" rows="2" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                            @error('beschreibung') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- Datei --}}
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700">Beleg (PDF/Foto)</label>
                            <div class="mt-1">
                                @if ($existingFile)
                                    <div class="flex items-center mb-2 space-x-2 text-xs text-blue-600">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                        <span>Bestehender Beleg vorhanden</span>
                                    </div>
                                @endif
                                <input type="file" wire:model="file" id="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            @error('file') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
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
