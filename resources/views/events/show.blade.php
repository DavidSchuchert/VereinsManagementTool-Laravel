@extends('layouts.app')
@section('title', $event->title)

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('events.index') }}" class="inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-500">
                    <svg class="mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Zurück zur Übersicht
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Event Details --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <h1 class="text-3xl font-extrabold text-gray-900">{{ $event->title }}</h1>
                                <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium {{ $event->event_date->isFuture() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $event->event_date->isFuture() ? 'Anstehend' : 'Vergangen' }}
                                </span>
                            </div>
                            
                            <div class="mt-4 flex flex-wrap gap-4 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    {{ $event->event_date->format('d.m.Y H:i') }} Uhr
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    {{ $event->location }}
                                </div>
                            </div>

                            <div class="mt-6 prose prose-purple max-w-none text-gray-700">
                                <h4 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-2">Beschreibung</h4>
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                    </div>

                    {{-- Attendance List Component --}}
                    @livewire('event-attendance', ['event' => $event])
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Teilnahme</h3>
                        <div class="flex items-center justify-between text-sm mb-4">
                            <span class="text-gray-500">Status:</span>
                            <span class="font-semibold">{{ $event->attendances->count() }} {{ $event->max_attendees ? '/ ' . $event->max_attendees : '' }} angemeldet</span>
                        </div>
                        
                        <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: {{ min(100, ($event->max_attendees ? ($event->attendances->count() / $event->max_attendees * 100) : 0)) }}%"></div>
                        </div>

                        @if($event->event_date->isFuture())
                            {{-- We can use the EventList attendance logic here too or just a simple check --}}
                            @auth
                                @php $isRegistered = $event->attendances()->where('user_id', auth()->id())->exists(); @endphp
                                <div class="space-y-3">
                                    <p class="text-xs text-center text-gray-400">Sie können sich jederzeit an- oder abmelden.</p>
                                    {{-- Integration with existing Livewire logic would be better, but for simplicity here: --}}
                                    <div class="text-center italic text-sm text-purple-600">
                                        Nutzen Sie die Übersicht zum Anmelden.
                                    </div>
                                </div>
                            @endauth
                        @else
                            <div class="p-3 bg-gray-50 rounded-md text-sm text-gray-500 text-center">
                                Dieses Event liegt in der Vergangenheit.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
