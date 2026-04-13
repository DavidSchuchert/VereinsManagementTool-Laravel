@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="py-6 animate-fade-in">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Welcome Header --}}
            <div class="mb-8 p-6 glass-panel flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-heading font-extrabold tracking-tight text-gray-900">Übersicht</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Willkommen zurück, <span class="font-semibold text-accent-600">{{ Auth::user()->name }}</span>.
                        <span class="text-gray-400">&bull;</span>
                        <span class="font-medium text-gray-700">{{ config('app.name') }}</span>
                    </p>
                </div>
            </div>

            {{-- Livewire Dashboard Component --}}
            @livewire('dashboard-stats')
        </div>
    </div>
@endsection
