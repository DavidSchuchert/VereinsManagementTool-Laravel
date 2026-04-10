@vite('resources/css/dashboard/index.css')
@extends('layouts.app')
@apexchartsScripts
@section('title', 'Dashboard')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Welcome Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Herzlich Willkommen <span class="font-semibold text-blue-600">{{ Auth::user()->name }}</span> im
                    <span class="font-semibold text-indigo-600">{{ config('app.name') }}</span>
                </p>
            </div>

            {{-- Livewire Dashboard Component --}}
            @livewire('dashboard-stats')
        </div>
    </div>
@endsection
