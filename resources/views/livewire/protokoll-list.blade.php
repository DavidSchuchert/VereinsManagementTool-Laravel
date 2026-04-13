<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">📜 Protokolle</h1>
        <button wire:click="$dispatch('open-protokoll-form')" class="btn-primary flex items-center shadow-lg transition-transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Neues Protokoll erstellen
        </button>
    </div>

    <div class="mb-4">
        <input wire:model.live="search" type="text" placeholder="Protokolle suchen..." class="search-input w-full p-2 border rounded">
    </div>

    @if ($protokolle->isNotEmpty())
        <table class="w-full">
            <tbody>
                @foreach ($protokolle as $protokoll)
                    <tr onclick="toggleExtra('{{ $protokoll->id }}')" class="cursor-pointer hover:bg-gray-100">
                        <td class="p-4 border-b">
                            <b>{{ $protokoll->title }}</b><br>
                            <span class="text-sm text-gray-600">
                                Erstellt von: {{ $protokoll->user->name }} | 
                                Am: {{ \Carbon\Carbon::parse($protokoll->created_at)->format('d.m.Y') }}
                            </span>
                        </td>
                    </tr>

                    <!-- Eingeklappter Bereich mit Aktionen -->
                    <tr class="createhidden" id="extra-{{ $protokoll->id }}">
                        <td class="p-4 border-b bg-gray-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div class="timestamp text-sm text-gray-600">
                                    <span class="timestamp-icon">📅</span>
                                    <span>Erstellt am: {{ $protokoll->created_at->format('d.m.Y H:i') }}</span>
                                </div>
                                <div class="timestamp text-sm text-gray-600">
                                    <span class="timestamp-icon">✏️</span>
                                    <span>Zuletzt bearbeitet am: {{ $protokoll->updated_at->format('d.m.Y H:i') }}</span>
                                </div>
                            </div>

                            <!-- Aktionen (Bearbeiten, Export, Löschen) -->
                            <div class="flex flex-wrap gap-4">
                                <button wire:click="$dispatch('open-protokoll-form', { id: {{ $protokoll->id }} })" class="flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
                                    <img src="{{ asset('images/edit-svgrepo-com.svg') }}" alt="bearbeiten" class="w-4 h-4">
                                    Bearbeiten
                                </button>
                                
                                <a href="{{ route('protokolle.exportSinglePdf', $protokoll) }}" class="flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded hover:bg-green-200">
                                    <img src="{{ asset('images/file-svgrepo-com.svg') }}" alt="exportieren" class="w-4 h-4">
                                    PDF Export
                                </a>

                                <button wire:click="delete({{ $protokoll->id }})" wire:confirm="Sicher löschen?" class="flex items-center gap-2 px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">
                                    <img src="{{ asset('images/delete-svgrepo-com.svg') }}" alt="löschen" class="w-4 h-4">
                                    Löschen
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="p-4 text-center text-gray-500">Keine Protokolle gefunden.</p>
    @endif

    <div class="mt-4">
        {{ $protokolle->links() }}
    </div>

    <script>
        function toggleExtra(id) {
            const extraRow = document.getElementById(`extra-${id}`);
            extraRow.classList.toggle('createhidden');
        }
    </script>
</div>
