<div x-data="{ open: $wire.entangle('showModal') }"
     x-show="open"
     @keydown.window.escape="open = false"
     class="relative z-50"
     style="display: none;">
    
    <div x-show="open"
         x-transition:enter="ease-in-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div x-show="open"
                     x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="pointer-events-auto w-screen max-w-md"
                     @click.away="open = false">
                    
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                        <div class="px-4 py-6 bg-blue-700 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-white" id="slide-over-title">Mitgliederdetails</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" @click="open = false" class="rounded-md bg-blue-700 text-blue-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                        <span class="sr-only">Schließen</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="relative flex-1 px-4 py-6 sm:px-6">
                            @if($member)
                                <div class="space-y-6">
                                    {{-- Personal Details Section --}}
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Persönliche Informationen</h3>
                                        <div class="mt-3 grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-xs text-gray-400">Vorname</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ $member->vorname }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-400">Nachname</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ $member->nachname }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-400">Geburtsdatum</p>
                                                <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($member->geburtsdatum)->format('d.m.Y') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-400">Mitgliedsnummer</p>
                                                <p class="text-sm font-mono font-bold text-blue-600">{{ $member->mitgliedsnummer }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="border-gray-100">

                                    {{-- Contact Section --}}
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Kontakt & Adresse</h3>
                                        <div class="mt-3 space-y-3">
                                            <div>
                                                <p class="text-xs text-gray-400">E-Mail</p>
                                                <p class="text-sm text-gray-900">{{ $member->email }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-400">Telefon</p>
                                                <p class="text-sm text-gray-900">{{ $member->telefon ?? 'Keine Angabe' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-400">Adresse</p>
                                                <p class="text-sm text-gray-900">{{ $member->strasse }} {{ $member->hausnummer }}</p>
                                                <p class="text-sm text-gray-900">{{ $member->plz }} {{ $member->ort }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="border-gray-100">

                                    {{-- Membership Section --}}
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Vereinsstatus</h3>
                                        <div class="mt-3 grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-xs text-gray-400">Eintritt</p>
                                                <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($member->eintrittsdatum)->format('d.m.Y') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-400">Rang</p>
                                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                                    {{ $member->rangart->name }}
                                                </span>
                                            </div>
                                            @if($member->austrittsdatum)
                                                <div class="col-span-2">
                                                    <p class="text-xs text-gray-400 text-red-500">Austrittsdatum</p>
                                                    <p class="text-sm text-red-600 font-bold">{{ \Carbon\Carbon::parse($member->austrittsdatum)->format('d.m.Y') }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <hr class="border-gray-100">

                                    {{-- File Section --}}
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Dokumente</h3>
                                        <div class="mt-3">
                                            @if($member->file_path)
                                                <a href="{{ Storage::url($member->file_path) }}" target="_blank" class="flex items-center p-3 rounded-lg border border-blue-100 bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors">
                                                    <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                                    <span class="text-sm font-medium">Dokument öffnen / Download</span>
                                                </a>
                                            @else
                                                <p class="text-sm text-gray-400 italic">Keine Dokumente hochgeladen.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-shrink-0 justify-end px-4 py-4 border-t border-gray-100 bg-gray-50">
                            <button type="button" @click="open = false" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Schließen</button>
                            <button type="button" wire:click="$dispatch('open-member-form', { id: {{ $member ? $member->id : 'null' }} })" @click="open = false" class="ml-3 inline-flex justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Bearbeiten</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
