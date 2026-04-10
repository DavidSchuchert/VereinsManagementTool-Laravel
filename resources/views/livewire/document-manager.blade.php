<div class="space-y-8 p-6">
    {{-- Upload Section --}}
    <div class="bg-white rounded-lg shadow p-6 border-2 border-dashed border-gray-300" 
         x-data="{ isDragging: false }"
         @dragover.prevent="isDragging = true"
         @dragleave.prevent="isDragging = false"
         @drop.prevent="isDragging = false; $refs.fileInput.files = $event.dataTransfer.files; $refs.fileInput.dispatchEvent(new Event('change'))"
         :class="{ 'border-blue-500 bg-blue-50': isDragging }">
        
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Dokument hochladen</h2>
        
        <form wire:submit.prevent="save" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Titel</label>
                    <input type="text" wire:model="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="z.B. Satzung 2024">
                    @error('title') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Beschreibung (optional)</label>
                    <input type="text" wire:model="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Kurze Info zum Inhalt">
                </div>
            </div>

            <div class="flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klicken</span> oder Drag & Drop</p>
                        <p class="text-xs text-gray-400">PDF, JPG, PNG (Max. 20MB)</p>
                    </div>
                    <input type="file" wire:model="files" multiple class="hidden" x-ref="fileInput" />
                </label>
            </div>
            
            @if ($files)
                <div class="text-sm text-blue-600">
                    {{ count($files) }} Datei(en) ausgewählt.
                </div>
            @endif

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <span wire:loading.remove wire:target="save">Hochladen</span>
                    <span wire:loading wire:target="save text-white">Wird hochgeladen...</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Search and Grid --}}
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Dokumenten-Archiv</h2>
            <div class="w-64">
                <input type="text" wire:model.live="search" placeholder="Suchen..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($documents as $doc)
                <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200 flex flex-col">
                    {{-- Preview --}}
                    <div class="h-40 bg-gray-100 flex items-center justify-center relative group">
                        @if($doc->isImage())
                            <img src="{{ asset('storage/' . $doc->file_path) }}" class="w-full h-full object-cover">
                        @elseif($doc->isPdf())
                            <svg class="w-16 h-16 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6l-4-4H9z" /><path d="M10 2v4a1 1 0 001 1h4" /></svg>
                        @else
                            <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        @endif
                        
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-opacity"></div>
                    </div>

                    {{-- Content --}}
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="font-bold text-gray-900 truncate" title="{{ $doc->title }}">{{ $doc->title }}</h3>
                        <p class="text-xs text-gray-500 mb-2">{{ $doc->readable_size }} | {{ $doc->created_at->format('d.m.Y') }}</p>
                        <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ $doc->description ?: 'Keine Beschreibung' }}</p>
                        
                        <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-xs text-gray-400">Vom: {{ $doc->user->name }}</span>
                            
                            <div class="flex space-x-2" x-data="{ open: false }">
                                <button wire:click="download({{ $doc->id }})" class="p-1 text-blue-600 hover:bg-blue-50 rounded" title="Herunterladen">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                </button>
                                
                                <button @click="if(confirm('Dokument endgültig löschen?')) $wire.delete({{ $doc->id }})" class="p-1 text-red-600 hover:bg-red-50 rounded" title="Löschen">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-lg shadow">
                    Keine Dokumente im Archiv gefunden.
                </div>
            @endforelse
        </div>
    </div>
</div>
