@extends('layouts.app')
@section('title', 'Dokumenten Management')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Dokumenten Management</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Zentrale Ablage für Vereinssatzungen, Verträge und sonstige Dokumente.
                </p>
            </div>

            @livewire('document-manager')
        </div>
    </div>
@endsection
