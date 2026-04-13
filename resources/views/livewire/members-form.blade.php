<div x-data="{ open: $wire.entangle('showModal') }" 
     @keydown.window.escape="open = false" 
     x-show="open" 
     class="relative z-50" 
     aria-labelledby="slide-over-title" 
     role="dialog" 
     aria-modal="true"
     style="display: none;">
    
    {{-- Background backdrop --}}
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
                            <div class="px-4 py-6 bg-blue-700 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-medium text-white" id="slide-over-title">
                                        {{ $memberId ? 'Mitglied bearbeiten' : 'Neues Mitglied anlegen' }}
                                    </h2>
                                    <div class="flex items-center ml-3 h-7">
                                        <button type="button" 
                                                class="text-blue-200 bg-blue-700 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white" 
                                                @click="open = false">
                                            <span class="sr-only">Schließen</span>
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <p class="text-sm text-blue-300">Bitte füllen Sie alle erforderlichen Felder aus.</p>
                                </div>
                            </div>
                            
                            <div class="flex flex-col justify-between flex-1">
                                <div class="px-4 py-6 space-y-6 sm:px-6">
                                    {{-- Mitgliedsnummer --}}
                                    <div>
                                        <label for="mitgliedsnummer" class="block text-sm font-medium text-gray-900">Mitgliedsnummer</label>
                                        <div class="mt-1">
                                            <input type="text" wire:model="mitgliedsnummer" id="mitgliedsnummer" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        </div>
                                        @error('mitgliedsnummer') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        {{-- Vorname --}}
                                        <div>
                                            <label for="vorname" class="block text-sm font-medium text-gray-900">Vorname</label>
                                            <div class="mt-1">
                                                <input type="text" wire:model="vorname" id="vorname" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            </div>
                                            @error('vorname') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- Nachname --}}
                                        <div>
                                            <label for="nachname" class="block text-sm font-medium text-gray-900">Nachname</label>
                                            <div class="mt-1">
                                                <input type="text" wire:model="nachname" id="nachname" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            </div>
                                            @error('nachname') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    {{-- E-Mail --}}
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-900">E-Mail Adresse</label>
                                        <div class="mt-1">
                                            <input type="email" wire:model="email" id="email" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        </div>
                                        @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Geburtsdatum --}}
                                    <div>
                                        <label for="geburtsdatum" class="block text-sm font-medium text-gray-900">Geburtsdatum</label>
                                        <div class="mt-1">
                                            <input type="date" wire:model="geburtsdatum" id="geburtsdatum" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        </div>
                                        @error('geburtsdatum') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="grid grid-cols-3 gap-4">
                                        {{-- PLZ --}}
                                        <div>
                                            <label for="plz" class="block text-sm font-medium text-gray-900">PLZ</label>
                                            <div class="mt-1">
                                                <input type="number" wire:model="plz" id="plz" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            </div>
                                            @error('plz') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- Ort --}}
                                        <div class="col-span-2">
                                            <label for="ort" class="block text-sm font-medium text-gray-900">Ort</label>
                                            <div class="mt-1">
                                                <input type="text" wire:model="ort" id="ort" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            </div>
                                            @error('ort') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-3 gap-4">
                                        {{-- Strasse --}}
                                        <div class="col-span-2">
                                            <label for="strasse" class="block text-sm font-medium text-gray-900">Straße</label>
                                            <div class="mt-1">
                                                <input type="text" wire:model="strasse" id="strasse" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            </div>
                                            @error('strasse') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- Hausnummer --}}
                                        <div>
                                            <label for="hausnummer" class="block text-sm font-medium text-gray-900">Nr.</label>
                                            <div class="mt-1">
                                                <input type="text" wire:model="hausnummer" id="hausnummer" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            </div>
                                            @error('hausnummer') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    {{-- Telefon --}}
                                    <div>
                                        <label for="telefon" class="block text-sm font-medium text-gray-900">Telefon / Handy</label>
                                        <div class="mt-1">
                                            <input type="text" wire:model="telefon" id="telefon" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        </div>
                                        @error('telefon') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        {{-- Eintrittsdatum --}}
                                        <div>
                                            <label for="eintrittsdatum" class="block text-sm font-medium text-gray-900">Eintritt</label>
                                            <div class="mt-1">
                                                <input type="date" wire:model="eintrittsdatum" id="eintrittsdatum" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            </div>
                                            @error('eintrittsdatum') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- Austrittsdatum --}}
                                        <div>
                                            <label for="austrittsdatum" class="block text-sm font-medium text-gray-900">Austritt (optional)</label>
                                            <div class="mt-1">
                                                <input type="date" wire:model="austrittsdatum" id="austrittsdatum" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            </div>
                                            @error('austrittsdatum') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    {{-- Rang --}}
                                    <div>
                                        <label for="rang_id" class="block text-sm font-medium text-gray-900">Rang</label>
                                        <div class="mt-1">
                                            <select wire:model="rang_id" id="rang_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                <option value="">Wählen Sie einen Rang...</option>
                                                @foreach($rangarten as $rang)
                                                    <option value="{{ $rang->id }}">{{ $rang->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('rang_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Datei --}}
                                    <div>
                                        <label for="file" class="block text-sm font-medium text-gray-900">Dokument / Foto</label>
                                        <div class="mt-1">
                                            @if ($existingFile)
                                                <div class="flex items-center justify-between mb-2 p-2 bg-blue-50 rounded-md border border-blue-100">
                                                    <div class="flex items-center space-x-2 text-xs text-blue-700 font-medium">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                                        <span>Bestehende Datei vorhanden</span>
                                                    </div>
                                                    <button type="button" 
                                                            wire:click="deleteFile" 
                                                            wire:confirm="Möchtest du das Dokument wirklich löschen?"
                                                            class="text-xs font-bold text-rose-600 hover:text-rose-800 transition-colors uppercase tracking-widest">
                                                        Löschen
                                                    </button>
                                                </div>
                                            @endif
                                            <input type="file" wire:model="file" id="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        </div>
                                        <div wire:loading wire:target="file" class="mt-1 text-xs text-blue-500">Hochladen...</div>
                                        @error('file') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end flex-shrink-0 px-4 py-4 space-x-3 border-t border-gray-200">
                            <button type="button" 
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" 
                                    @click="open = false">Abbrechen</button>
                            <button type="submit" 
                                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
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
