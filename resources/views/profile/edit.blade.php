@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 animate-fade-in">
    <div class="mb-8">
        <h1 class="text-3xl font-heading font-extrabold text-gray-900 tracking-tight">Mein Konto</h1>
        <p class="text-gray-500 mt-1">Verwalten Sie Ihre persönlichen Informationen und Sicherheitseinstellungen.</p>
    </div>

    <div class="space-y-8">
        {{-- Profile Information --}}
        <div class="card-premium p-6 sm:p-8">
            <div class="flex items-start gap-4 mb-8">
                <div class="p-3 bg-accent-50 text-accent-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Profilinformationen</h2>
                    <p class="text-sm text-gray-500 mt-1 italic">Aktualisieren Sie Ihren Namen und Ihre E-Mail-Adresse.</p>
                </div>
            </div>
            
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Update Password --}}
        <div class="card-premium p-6 sm:p-8">
            <div class="flex items-start gap-4 mb-8">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Passwort ändern</h2>
                    <p class="text-sm text-gray-500 mt-1 italic">Verwenden Sie ein langes, zufälliges Passwort für maximale Sicherheit.</p>
                </div>
            </div>

            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete Account --}}
        <div class="card-premium p-6 sm:p-8 border-rose-100 shadow-rose-100/20 bg-rose-50/10">
            <div class="flex items-start gap-4 mb-8">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-rose-900">Konto löschen</h2>
                    <p class="text-sm text-rose-700/60 mt-1 italic">Vorsicht: Dieser Vorgang kann nicht rückgängig gemacht werden.</p>
                </div>
            </div>

            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
