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
         class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

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
                            <div class="px-4 py-6 bg-emerald-700 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-medium text-white" id="slide-over-title">
                                        {{ $zahlungId ? 'Zahlung bearbeiten' : 'Neue Zahlung erfassen' }}
                                    </h2>
                                    <div class="flex items-center ml-3 h-7">
                                        <button type="button" class="text-emerald-200 bg-emerald-700 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white" @click="open = false">
                                            <span class="sr-only">Schließen</span>
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col justify-between flex-1">
                                <div class="px-4 py-6 space-y-6 sm:px-6">
                                    {{-- Type Toggle --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-900 mb-2">Transaktionstyp</label>
                                        <div class="flex items-center p-1 space-x-1 bg-gray-100 rounded-lg">
                                            <button type="button" wire:click="$set('typ', 'Einnahme')" class="flex-1 px-4 py-2 text-sm font-medium rounded-md transition-colors {{ $typ === 'Einnahme' ? 'bg-emerald-600 text-white shadow' : 'text-gray-500 hover:text-gray-700' }}">Einnahme</button>
                                            <button type="button" wire:click="$set('typ', 'Ausgabe')" class="flex-1 px-4 py-2 text-sm font-medium rounded-md transition-colors {{ $typ === 'Ausgabe' ? 'bg-red-600 text-white shadow' : 'text-gray-500 hover:text-gray-700' }}">Ausgabe</button>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        {{-- Betrag --}}
                                        <div>
                                            <label for="betrag" class="block text-sm font-medium text-gray-900">Betrag (€)</label>
                                            <input type="number" step="0.01" wire:model="betrag" id="betrag" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                                            @error('betrag') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- Datum --}}
                                        <div>
                                            <label for="datum" class="block text-sm font-medium text-gray-900">Datum</label>
                                            <input type="date" wire:model="datum" id="datum" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                                            @error('datum') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    {{-- Zahlungsart --}}
                                    <div>
                                        <label for="zahlungsart_id" class="block text-sm font-medium text-gray-900">Zahlungsart</label>
                                        <select wire:model="zahlungsart_id" id="zahlungsart_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                                            <option value="">Wählen...</option>
                                            @foreach($zahlungsarten as $art)
                                                <option value="{{ $art->id }}">{{ $art->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('zahlungsart_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Rechnungsnummer --}}
                                    <div>
                                        <label for="rechnungsnr" class="block text-sm font-medium text-gray-900">Rechnungsnummer</label>
                                        <input type="text" wire:model="rechnungsnr" id="rechnungsnr" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                                        @error('rechnungsnr') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Beschreibung --}}
                                    <div>
                                        <label for="beschreibung" class="block text-sm font-medium text-gray-900">Beschreibung</label>
                                        <textarea wire:model="beschreibung" id="beschreibung" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"></textarea>
                                        @error('beschreibung') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- File --}}
                                    <div>
                                        <label for="file" class="block text-sm font-medium text-gray-900">Beleg (PDF/Foto)</label>
                                        <div class="mt-1">
                                            @if ($existingFile)
                                                <div class="flex items-center justify-between mb-2 p-2 bg-emerald-50 rounded-md border border-emerald-100">
                                                    <div class="flex items-center space-x-2 text-xs text-emerald-700 font-medium">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                                        <span>Bestehender Beleg vorhanden</span>
                                                    </div>
                                                    <button type="button" 
                                                            wire:click="deleteFile" 
                                                            wire:confirm="Möchtest du diesen Beleg wirklich löschen?"
                                                            class="text-xs font-bold text-rose-600 hover:text-rose-800 transition-colors uppercase tracking-widest">
                                                        Löschen
                                                    </button>
                                                </div>
                                            @endif
                                            <input type="file" wire:model="file" id="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                        </div>
                                        <div wire:loading wire:target="file" class="mt-1 text-xs text-emerald-500">Hochladen...</div>
                                        @error('file') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end flex-shrink-0 px-4 py-4 space-x-3 border-t border-gray-200">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50" @click="open = false">Abbrechen</button>
                            <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-md shadow-sm hover:bg-emerald-700">
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
