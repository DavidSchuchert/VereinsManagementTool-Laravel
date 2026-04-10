@extends('layouts.app')
@section('title', 'Veranstaltungen')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- The Livewire Event List --}}
            @livewire('event-list')

            {{-- The Livewire Event Form (Slide-over) --}}
            @livewire('event-form')
        </div>
    </div>
@endsection
