@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 animate-fade-in">
    <div class="mb-8">
        <a href="{{ route('users.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-accent-600 transition-colors mb-4 group">
            <svg class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Zurück zur Übersicht
        </a>
        <h1 class="text-3xl font-heading font-extrabold text-gray-900 tracking-tight">Benutzer bearbeiten</h1>
        <p class="text-gray-500 mt-1">Passen Sie die Zugangsdaten für <strong>{{ $user->name }}</strong> an.</p>
    </div>

    <div class="card-premium p-8 shadow-xl shadow-gray-200/50">
        <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Voller Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <input type="text" name="name" id="name" required
                           class="block w-full pl-10 border-gray-200 rounded-xl focus:border-accent-500 focus:ring-accent-500 text-sm transition-all shadow-sm"
                           placeholder="z.B. Max Mustermann" value="{{ old('name', $user->name) }}">
                </div>
                @error('name')
                    <p class="mt-2 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-1">E-Mail Adresse</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 108 0 4 4 0 00-8 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                    </div>
                    <input type="email" name="email" id="email" required
                           class="block w-full pl-10 border-gray-200 rounded-xl focus:border-accent-500 focus:ring-accent-500 text-sm transition-all shadow-sm"
                           placeholder="email@beispiel.de" value="{{ old('email', $user->email) }}">
                </div>
                @error('email')
                    <p class="mt-2 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Passwort ändern</h3>
                </div>
                <p class="text-xs text-gray-500 mb-4">Nur ausfüllen, wenn das Passwort neu gesetzt werden soll. Ansonsten leer lassen.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <input type="password" name="password" id="password" autocomplete="new-password"
                               placeholder="Neues Passwort"
                               class="block w-full border-gray-200 rounded-xl focus:border-accent-500 focus:ring-accent-500 text-sm transition-all shadow-sm">
                        @error('password')
                            <p class="mt-2 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                               placeholder="Passwort bestätigen"
                               class="block w-full border-gray-200 rounded-xl focus:border-accent-500 focus:ring-accent-500 text-sm transition-all shadow-sm">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end items-center gap-4">
                <a href="{{ route('users.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-700">Abbrechen</a>
                <button type="submit" class="btn-primary px-8 py-3 text-base shadow-lg shadow-accent-200 hover:shadow-accent-300 transition-all">
                    Änderungen speichern
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
