

@extends('layouts.app')
@section('title', 'Zahlungen')

@section('content')
    <section class="p-6">
        {{-- The Livewire Zahlungen List --}}
        @livewire('zahlungen-list')

        {{-- The Livewire Zahlungen Form (Modal) --}}
        @livewire('zahlungen-form')
    </section>
@endsection
