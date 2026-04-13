@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 animate-fade-in">
    <div class="mb-8">
        <a href="{{ route('users.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-accent-600 transition-colors mb-4 group">
            <svg class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Zurück zur Übersicht
        </a>
        <h1 class="text-3xl font-heading font-extrabold text-gray-900 tracking-tight">Benutzer erstellen</h1>
        <p class="text-gray-500 mt-1">Legen Sie einen neuen Systemzugang fest.</p>
    </div>

    <div class="card-premium p-8">
        <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Voller Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <input type="text" name="name" id="name" required autofocus
                           class="block w-full pl-10 border-gray-200 rounded-xl focus:border-accent-500 focus:ring-accent-500 text-sm transition-all"
                           placeholder="z.B. Max Mustermann" value="{{ old('name') }}">
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
                           class="block w-full pl-10 border-gray-200 rounded-xl focus:border-accent-500 focus:ring-accent-500 text-sm transition-all"
                           placeholder="email@beispiel.de" value="{{ old('email') }}">
                </div>
                @error('email')
                    <p class="mt-2 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Passwort</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" name="password" id="password" required
                               class="block w-full pl-10 border-gray-200 rounded-xl focus:border-accent-500 focus:ring-accent-500 text-sm transition-all">
                    </div>
                    @error('password')
                        <p class="mt-2 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1">Passwort bestätigen</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="block w-full pl-10 border-gray-200 rounded-xl focus:border-accent-500 focus:ring-accent-500 text-sm transition-all">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end">
                <button type="submit" class="btn-primary px-8 py-3 text-base shadow-lg shadow-accent-200 hover:shadow-accent-300">
                    Benutzer anlegen
                </button>
            </div>
        </form>
    </div>

    <div class="mt-8 p-4 bg-amber-50 rounded-2xl border border-amber-100 flex gap-3 items-start">
        <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <p class="text-sm text-amber-800">
            <strong>Hinweis:</strong> Neue Benutzer haben vollen Zugriff auf das System. Bitte vergeben Sie Passwörter sorgfältig.
        </p>
    </div>
</div>
@endsection
