<div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
    {{-- Wizard Navigation --}}
    <div class="flex border-b border-gray-200 bg-gray-50">
        <button wire:click="setTab('export')" 
                class="flex-1 py-4 text-sm font-bold transition-all {{ $activeTab === 'export' ? 'text-blue-600 bg-white border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
            📥 DATEN EXPORTIEREN
        </button>
        <button wire:click="setTab('import')" 
                class="flex-1 py-4 text-sm font-bold transition-all {{ $activeTab === 'import' ? 'text-green-600 bg-white border-b-2 border-green-600' : 'text-gray-500 hover:text-gray-700' }}">
            📤 DATEN IMPORTIEREN
        </button>
    </div>

    <div class="p-8">
        {{-- Category Selection --}}
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">Was möchten Sie verarbeiten?</label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <label class="relative flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $selectedEntity === 'members' ? 'border-blue-500 bg-blue-50 ring-1 ring-blue-500' : 'border-gray-200' }}">
                    <input type="radio" wire:model.live="selectedEntity" value="members" class="sr-only">
                    <span class="flex flex-col">
                        <span class="text-sm font-bold text-gray-900">Mitglieder</span>
                        <span class="text-xs text-gray-500">Stammdaten & Ränge</span>
                    </span>
                </label>
                <label class="relative flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $selectedEntity === 'inventory' ? 'border-blue-500 bg-blue-50 ring-1 ring-blue-500' : 'border-gray-200' }}">
                    <input type="radio" wire:model.live="selectedEntity" value="inventory" class="sr-only">
                    <span class="flex flex-col">
                        <span class="text-sm font-bold text-gray-900">Inventar</span>
                        <span class="text-xs text-gray-500">Artikel & Bestände</span>
                    </span>
                </label>
                <label class="relative flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $selectedEntity === 'protocols' ? 'border-blue-500 bg-blue-50 ring-1 ring-blue-500' : 'border-gray-200' }}">
                    <input type="radio" wire:model.live="selectedEntity" value="protocols" class="sr-only">
                    <span class="flex flex-col">
                        <span class="text-sm font-bold text-gray-900">Protokolle</span>
                        <span class="text-xs text-gray-500">Sitzungen & Notizen</span>
                    </span>
                </label>
            </div>
        </div>

        {{-- Export Tab --}}
        <div x-show="$wire.activeTab === 'export'" x-transition>
            <div class="text-center py-12 bg-blue-50 rounded-xl border border-blue-100">
                <svg class="mx-auto h-12 w-12 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Export starten</h3>
                <p class="mt-1 text-sm text-gray-500">Laden Sie die aktuellen Daten als Excel-Datei herunter.</p>
                <div class="mt-6">
                    <button wire:click="export" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        Download (.xlsx)
                    </button>
                </div>
            </div>
        </div>

        {{-- Import Tab --}}
        <div x-show="$wire.activeTab === 'import'" x-transition x-cloak>
            <div class="space-y-6">
                {{-- Dropzone --}}
                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klicken</span> oder Datei hierher ziehen</p>
                            <p class="text-xs text-gray-400">Excel oder CSV (Max. 10MB)</p>
                        </div>
                        <input type="file" wire:model="importFile" class="hidden" />
                    </label>
                </div>

                @error('importFile') <span class="text-sm text-red-600">{{ $message }}</span> @enderror

                {{-- Preview Section --}}
                @if($importFile && !empty($importPreview))
                    <div class="mt-8 animate-fade-in">
                        <h4 class="text-md font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            Vorschau der Daten
                        </h4>
                        <div class="overflow-x-auto border rounded-lg shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @foreach($importPreview[0] as $header)
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ $header }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach(array_slice($importPreview, 1) as $row)
                                        <tr>
                                            @foreach($row as $cell)
                                                <td class="px-4 py-2 text-sm text-gray-600">{{ $cell }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Action Button --}}
                        <div class="mt-6 flex justify-end">
                            <button wire:click="startImport" 
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none disabled:opacity-50">
                                <span wire:loading.remove wire:target="startImport">Import jetzt starten</span>
                                <span wire:loading wire:target="startImport">Verarbeite Daten...</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Progress Overlay --}}
    <div wire:loading wire:target="importFile, startImport" class="fixed inset-0 z-[110] flex items-center justify-center bg-black bg-opacity-25 backdrop-blur-sm">
        <div class="bg-white p-6 rounded-xl shadow-2xl flex flex-col items-center">
            <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
            <p class="mt-4 font-bold text-gray-800">Verarbeite Anfrage...</p>
        </div>
    </div>
</div>
