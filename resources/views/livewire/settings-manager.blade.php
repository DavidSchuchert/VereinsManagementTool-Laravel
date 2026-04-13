<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    {{-- Logo Management --}}
    <div class="card-premium p-6 flex flex-col h-full">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-sm">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Vereinslogo</h3>
                <p class="text-xs text-gray-500">Wird in der Navigation und auf Dokumenten angezeigt.</p>
            </div>
        </div>

        <div class="flex-1 flex flex-col justify-center items-center py-8 bg-gray-50/50 rounded-2xl border border-dashed border-gray-200 mb-6">
            @if($currentLogo)
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-accent-500 to-indigo-600 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                    <div class="relative bg-white p-4 rounded-xl shadow-sm border border-gray-100 transition-all duration-300 transform group-hover:scale-105">
                        <img src="{{ asset('storage/' . $currentLogo) }}" alt="Aktuelles Logo" class="h-24 object-contain">
                    </div>
                </div>
            @else
                <div class="w-24 h-24 bg-white rounded-xl border border-gray-100 shadow-sm flex items-center justify-center text-gray-300">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            @endif
        </div>

        <form wire:submit.prevent="uploadLogo" class="mt-auto space-y-4">
            <div>
                <label for="logo" class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Datei auswählen</label>
                <input type="file" wire:model="logo" id="logo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer">
                <div wire:loading wire:target="logo" class="mt-2 text-xs text-blue-500 flex items-center gap-2">
                    <svg class="animate-spin h-3 w-3 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Wird hochgeladen...
                </div>
                @if($errors->has('logo'))
                    <span class="text-rose-500 text-[10px] font-bold mt-1 block tracking-wide uppercase">{{ $errors->first('logo') }}</span>
                @endif
            </div>
            
            <button type="submit" class="w-full btn-primary py-3 flex items-center justify-center gap-2 group" wire:loading.attr="disabled">
                <span>Logo speichern</span>
                <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </button>
        </form>
    </div>

    {{-- App Name Management --}}
    <div class="card-premium p-6 flex flex-col h-full">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 shadow-sm">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Vereinsname</h3>
                <p class="text-xs text-gray-500">Legt den Namen fest, der systemweit genutzt wird.</p>
            </div>
        </div>

        <div class="flex-1">
            <div class="p-4 rounded-xl shadow-sm border border-amber-100 bg-amber-50/50 mb-6 border-l-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xs text-amber-800 leading-relaxed font-medium line-clamp-2 italic">
                        Hinweis: Nach der Änderung des Namens muss die Seite einmal neu geladen werden, damit der Titel in der Kopfzeile aktualisiert wird.
                    </p>
                </div>
            </div>

            <form wire:submit.prevent="updateAppName" class="space-y-6">
                <div>
                    <label for="app_name" class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Name der Organisation</label>
                    <input 
                        type="text" 
                        wire:model="appName" 
                        id="app_name" 
                        class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all"
                        placeholder="z.B. Sportverein Musterstadt e.V."
                    >
                    @if($errors->has('appName'))
                        <span class="text-rose-500 text-[10px] font-bold mt-1 block tracking-wide uppercase">{{ $errors->first('appName') }}</span>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full btn-primary py-3 bg-indigo-600 hover:bg-indigo-700 flex items-center justify-center gap-2 group transition-all">
                        <span>Name aktualisieren</span>
                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </button>
                    <p class="text-[10px] text-center text-gray-400 mt-4 italic">Änderungen werden direkt in der Konfiguration gespeichert.</p>
                </div>
            </form>
        </div>
    </div>
</div>
