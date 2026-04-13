<div class="space-y-6">
    {{-- Add New Item --}}
    <div class="card-premium p-6">
        <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Neue(n) {{ $title }} hinzufügen
        </h3>
        <form wire:submit.prevent="save" class="flex gap-3">
            <div class="flex-1">
                <input type="text" wire:model.defer="newName" 
                       placeholder="Bezeichnung eingeben..." 
                       class="block w-full border-gray-200 rounded-xl focus:border-accent-500 focus:ring-accent-500 text-sm transition-all @error('newName') border-rose-500 bg-rose-50 @enderror">
                @error('newName') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn-primary py-2 px-6">
                Speichern
            </button>
        </form>
    </div>

    {{-- Items List --}}
    <div class="card-premium overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Bezeichnung</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Aktionen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($items as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            @if ($editingId === $item->id)
                                <div class="flex items-center gap-2">
                                    <input type="text" wire:model.defer="editingName" 
                                           class="flex-1 border-accent-500 rounded-lg text-sm focus:ring-accent-500 py-1">
                                    <button wire:click="update" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg" title="Bestätigen">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                    <button wire:click="cancelEdit" class="p-1.5 text-gray-400 hover:bg-gray-100 rounded-lg" title="Abbrechen">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                                @error('editingName') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                            @else
                                <span class="text-sm font-medium text-gray-700">{{ $item->name }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 items-center">
                                @if ($editingId !== $item->id)
                                    <button wire:click="startEdit({{ $item->id }}, '{{ addslashes($item->name) }}')" 
                                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all opacity-0 group-hover:opacity-100" title="Bearbeiten">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    
                                    <button wire:click="delete({{ $item->id }})" 
                                            onclick="return confirm('Möchten Sie dieses Element wirklich löschen?') || event.stopImmediatePropagation()"
                                            class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all opacity-0 group-hover:opacity-100" title="Löschen">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-10 text-center text-gray-400 italic text-sm">
                            Keine Einträge vorhanden.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
