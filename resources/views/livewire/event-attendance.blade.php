<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="p-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
        <h3 class="text-lg font-bold text-gray-800">Teilnehmerliste ({{ $attendances->count() }})</h3>
        <div class="max-w-xs">
            <input type="text" wire:model.live="search" placeholder="Teilnehmer suchen..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Angemeldet am</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Anwesend?</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($attendances as $attendance)
                    <tr class="{{ $attendance->attended ? 'bg-green-50' : '' }} transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $attendance->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $attendance->created_at->format('d.m.Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <button wire:click="toggleAttended({{ $attendance->id }})" 
                                    class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 {{ $attendance->attended ? 'bg-purple-600' : 'bg-gray-200' }}">
                                <span class="sr-only">Anwesenheit markieren</span>
                                <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 {{ $attendance->attended ? 'translate-x-5' : 'translate-x-0' }}"></span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500 italic">
                            Noch keine Anmeldungen für dieses Event.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
