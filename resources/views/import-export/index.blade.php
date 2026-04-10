@extends('layouts.app')
@section('title', 'Import & Export Wizard')

@section('content')
    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Daten-Schnittstelle</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Migrieren Sie Daten via Excel/CSV oder erstellen Sie Backups Ihrer Bestände.
                </p>
            </div>

            {{-- Alert if package might be missing (optional check) --}}
            @if(!class_exists('Maatwebsite\Excel\Facades\Excel'))
                <div class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700">
                    <p class="font-bold">Hinweis:</p>
                    <p>Das Excel-Paket wurde in der Konfiguration vorgemerkt. Bitte führen Sie <code>composer update</code> aus, um die volle Funktionalität zu aktivieren.</p>
                </div>
            @endif

            @livewire('import-export-wizard')
        </div>
    </div>
@endsection
